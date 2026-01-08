<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\PropertyApplication;
use App\Models\Property;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display all applications for the agency
     */
    public function index(Request $request)
    {
        $agency = auth()->user()->agency;
        
        if (!$agency) {
            return redirect()->route('agency.dashboard')
                ->with('error', 'No agency found for your account.');
        }

        $query = PropertyApplication::where('agency_id', $agency->id)
            ->with(['user', 'property'])
            ->latest();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhereHas('property', function($pq) use ($search) {
                    $pq->where('headline', 'like', "%{$search}%")
                        ->orWhere('street_name', 'like', "%{$search}%")
                        ->orWhere('suburb', 'like', "%{$search}%");
                });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Property filter
        if ($request->filled('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }

        // Property inspection filter
        if ($request->filled('inspected')) {
            $query->where('property_inspection', $request->inspected);
        }

        // Paginate
        $applications = $query->paginate(20)->appends($request->except('page'));

        // Get properties for filter dropdown
        $properties = Property::where('agency_id', $agency->id)
            ->orderBy('headline')
            ->get(['id', 'headline', 'street_number', 'street_name', 'suburb', 'state', 'postcode']);

        // Statistics
        $stats = [
            'total' => PropertyApplication::where('agency_id', $agency->id)->count(),
            'pending' => PropertyApplication::where('agency_id', $agency->id)->where('status', 'pending')->count(),
            'under_review' => PropertyApplication::where('agency_id', $agency->id)->where('status', 'under_review')->count(),
            'approved' => PropertyApplication::where('agency_id', $agency->id)->where('status', 'approved')->count(),
            'rejected' => PropertyApplication::where('agency_id', $agency->id)->where('status', 'rejected')->count(),
            'today' => PropertyApplication::where('agency_id', $agency->id)
                ->whereDate('submitted_at', today())
                ->count(),
            'this_week' => PropertyApplication::where('agency_id', $agency->id)
                ->whereBetween('submitted_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'inspected' => PropertyApplication::where('agency_id', $agency->id)
                ->where('property_inspection', 'yes')
                ->count(),
        ];

        return view('agency.applications.index', compact('applications', 'properties', 'stats'));
    }

    /**
     * Display a single application
     */
    public function show(PropertyApplication $application)
    {
        $agency = auth()->user()->agency;
        
        // Check if application belongs to this agency
        if ($application->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to this application.');
        }

        // Load relationships
        $application->load(['user', 'property.images', 'property.agents' => function($query) {
            $query->wherePivot('role', 'listing_agent');
        }]);

        return view('agency.applications.show', compact('application'));
    }

    /**
     * Approve an application and create tenant record
     */
    public function approve(PropertyApplication $application)
    {
        $agency = auth()->user()->agency;
        
        // Check if application belongs to this agency
        if ($application->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to this application.');
        }

        // Check if already approved/rejected
        if (in_array($application->status, ['approved', 'rejected'])) {
            return back()->with('error', 'This application has already been processed.');
        }

        // Check if already converted to tenant
        if ($application->hasBeenConvertedToTenant()) {
            return back()->with('error', 'This application has already been converted to a tenant.');
        }

        DB::beginTransaction();
        
        try {
            // Update application status
            $application->update([
                'status' => 'approved',
                'approved_at' => now(),
                'reviewed_at' => now(),
            ]);

            // Create Tenant record
            $tenant = Tenant::create([
                'user_id' => $application->user_id,
                'property_id' => $application->property_id,
                'agency_id' => $application->agency_id,
                'application_id' => $application->id,
                
                // Personal Information
                'first_name' => $application->first_name,
                'last_name' => $application->last_name,
                'email' => $application->email,
                'phone' => $application->phone,
                'date_of_birth' => $application->date_of_birth,
                
                // Lease Information
                'lease_start_date' => $application->move_in_date,
                'lease_end_date' => $application->move_in_date->addMonths($application->lease_term),
                'lease_term_months' => $application->lease_term,
                'rent_amount' => $application->property->rent_per_week ?? $application->property->rent_per_month ?? 0,
                'payment_frequency' => $application->property->rent_per_week ? 'weekly' : 'monthly',
                
                // Bond Information
                'bond_amount' => $application->property->bond_amount ?? 0,
                'bond_paid' => false,
                
                // Additional Occupants
                'additional_occupants' => $application->occupants_details,
                
                // Status
                'status' => 'pending_move_in',
                
                // Notes
                'notes' => "Created from application #{$application->id}\n\n" . 
                        "Special Requests: {$application->special_requests}\n\n" .
                        "Application Notes: {$application->notes}",
            ]);

            // Send notification to user
            $this->notificationService->system([
                'title' => 'Application Approved!',
                'message' => "Congratulations! Your rental application for {$application->property->headline} has been approved. You are now registered as a tenant. The agency will contact you soon with lease details and next steps.",
                'category' => 'approval',
                'priority' => 'high',
                'recipient_id' => $application->user_id,
                'action_url' => route('user.applications.show', $application->id),
                'action_text' => 'View Application',
                'metadata' => [
                    'application_id' => $application->id,
                    'property_id' => $application->property_id,
                    'tenant_id' => $tenant->id,
                ],
            ]);

            DB::commit();

            return back()->with('success', 'Application approved successfully! Tenant record created. Notification sent to applicant.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Application approval failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to approve application. Please try again.');
        }
    }

    /**
     * Reject an application
     */
    public function reject(Request $request, PropertyApplication $application)
    {
        $agency = auth()->user()->agency;
        
        // Check if application belongs to this agency
        if ($application->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to this application.');
        }

        // Check if already approved/rejected
        if (in_array($application->status, ['approved', 'rejected'])) {
            return back()->with('error', 'This application has already been processed.');
        }

        // Validate rejection reason
        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10|max:1000',
        ]);

        DB::beginTransaction();
        
        try {
            // Update application status
            $application->update([
                'status' => 'rejected',
                'rejected_at' => now(),
                'reviewed_at' => now(),
                'rejection_reason' => $validated['rejection_reason'],
            ]);

            // Send notification to user
            $this->notificationService->system([
                'title' => 'Application Update',
                'message' => "Your rental application for {$application->property->headline} has been reviewed. Please check your application for details.",
                'category' => 'approval',
                'priority' => 'high',
                'recipient_id' => $application->user_id,
                'action_url' => route('user.applications.show', $application->id),
                'action_text' => 'View Application',
                'metadata' => [
                    'application_id' => $application->id,
                    'property_id' => $application->property_id,
                ],
            ]);

            DB::commit();

            return back()->with('success', 'Application rejected. Notification sent to applicant.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Application rejection failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to reject application. Please try again.');
        }
    }

    /**
     * Mark application as under review
     */
    public function markUnderReview(PropertyApplication $application)
    {
        $agency = auth()->user()->agency;
        
        // Check if application belongs to this agency
        if ($application->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to this application.');
        }

        // Check if status is pending
        if ($application->status !== 'pending') {
            return back()->with('error', 'Only pending applications can be marked as under review.');
        }

        try {
            $application->update([
                'status' => 'under_review',
            ]);

            // Send notification to user
            $this->notificationService->system([
                'title' => 'Application Under Review',
                'message' => "Your rental application for {$application->property->headline} is now under review. We will notify you once a decision has been made.",
                'category' => 'approval',
                'priority' => 'medium',
                'recipient_id' => $application->user_id,
                'action_url' => route('user.applications.show', $application->id),
                'action_text' => 'View Application',
                'metadata' => [
                    'application_id' => $application->id,
                ],
            ]);

            return back()->with('success', 'Application marked as under review.');
            
        } catch (\Exception $e) {
            \Log::error('Mark under review failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to update application status.');
        }
    }
}