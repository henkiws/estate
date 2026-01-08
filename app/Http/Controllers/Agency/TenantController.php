<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Property;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display all tenants for the agency
     */
    public function index(Request $request)
    {
        $agency = auth()->user()->agency;
        
        if (!$agency) {
            return redirect()->route('agency.dashboard')
                ->with('error', 'No agency found for your account.');
        }

        $query = Tenant::where('agency_id', $agency->id)
            ->with(['user', 'property'])
            ->latest();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('tenant_code', 'like', "%{$search}%")
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

        // Bond status filter
        if ($request->filled('bond_status')) {
            if ($request->bond_status === 'paid') {
                $query->where('bond_paid', true);
            } elseif ($request->bond_status === 'unpaid') {
                $query->where('bond_paid', false);
            }
        }

        // Lease expiring filter
        if ($request->filled('lease_expiring')) {
            $days = (int) $request->lease_expiring;
            $query->expiringWithin($days);
        }

        // Payment overdue filter
        if ($request->filled('payment_overdue') && $request->payment_overdue === 'yes') {
            $query->whereDate('next_payment_due', '<', now());
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('lease_start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('lease_start_date', '<=', $request->date_to);
        }

        // Paginate
        $tenants = $query->paginate(20)->appends($request->except('page'));

        // Get properties for filter dropdown
        $properties = Property::where('agency_id', $agency->id)
            ->orderBy('headline')
            ->get(['id', 'headline', 'street_number', 'street_name', 'suburb', 'state', 'postcode']);

        // Statistics
        $stats = [
            'total' => Tenant::where('agency_id', $agency->id)->count(),
            'active' => Tenant::where('agency_id', $agency->id)->where('status', 'active')->count(),
            'pending_move_in' => Tenant::where('agency_id', $agency->id)->where('status', 'pending_move_in')->count(),
            'notice_given' => Tenant::where('agency_id', $agency->id)->where('status', 'notice_given')->count(),
            'ending' => Tenant::where('agency_id', $agency->id)->where('status', 'ending')->count(),
            'expiring_soon' => Tenant::where('agency_id', $agency->id)
                ->active()
                ->expiringWithin(60)
                ->count(),
            'bond_unpaid' => Tenant::where('agency_id', $agency->id)
                ->where('bond_paid', false)
                ->whereIn('status', ['pending_move_in', 'active'])
                ->count(),
            'payment_overdue' => Tenant::where('agency_id', $agency->id)
                ->where('status', 'active')
                ->whereDate('next_payment_due', '<', now())
                ->count(),
        ];

        return view('agency.tenants.index', compact('tenants', 'properties', 'stats'));
    }

    /**
     * Display a single tenant
     */
    public function show(Tenant $tenant)
    {
        $agency = auth()->user()->agency;
        
        // Check if tenant belongs to this agency
        if ($tenant->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to this tenant.');
        }

        // Load relationships
        $tenant->load(['user', 'property.images', 'application']);

        return view('agency.tenants.show', compact('tenant'));
    }

    /**
     * Show edit form
     */
    public function edit(Tenant $tenant)
    {
        $agency = auth()->user()->agency;
        
        // Check if tenant belongs to this agency
        if ($tenant->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to this tenant.');
        }

        // Load relationships
        $tenant->load(['property']);

        return view('agency.tenants.edit', compact('tenant'));
    }

    /**
     * Update tenant information
     */
    public function update(Request $request, Tenant $tenant)
    {
        $agency = auth()->user()->agency;
        
        // Check if tenant belongs to this agency
        if ($tenant->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to this tenant.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'lease_start_date' => 'required|date',
            'lease_end_date' => 'required|date|after:lease_start_date',
            'rent_amount' => 'required|numeric|min:0',
            'payment_frequency' => 'required|in:weekly,fortnightly,monthly',
            'bond_amount' => 'required|numeric|min:0',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:5000',
        ]);

        try {
            $tenant->update($validated);

            return redirect()->route('agency.tenants.show', $tenant)
                ->with('success', 'Tenant information updated successfully.');
            
        } catch (\Exception $e) {
            \Log::error('Tenant update failed: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Failed to update tenant information. Please try again.');
        }
    }

    /**
     * Mark tenant as moved in
     */
    public function markAsMovedIn(Tenant $tenant)
    {
        $agency = auth()->user()->agency;
        
        // Check if tenant belongs to this agency
        if ($tenant->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to this tenant.');
        }

        // Check if already moved in
        if ($tenant->status === 'active') {
            return back()->with('error', 'This tenant has already moved in.');
        }

        try {
            $tenant->markAsMovedIn();

            // Send notification to tenant
            $this->notificationService->system([
                'title' => 'Welcome to Your New Home!',
                'message' => "Welcome! You have been marked as moved in to {$tenant->property->headline}. We hope you enjoy your new home. Please don't hesitate to contact us if you need anything.",
                'category' => 'general',
                'priority' => 'medium',
                'recipient_id' => $tenant->user_id,
                'metadata' => [
                    'tenant_id' => $tenant->id,
                    'property_id' => $tenant->property_id,
                ],
            ]);

            return back()->with('success', 'Tenant marked as moved in successfully. Notification sent.');
            
        } catch (\Exception $e) {
            \Log::error('Mark as moved in failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to update tenant status. Please try again.');
        }
    }

    /**
     * Mark tenant as moved out
     */
    public function markAsMovedOut(Tenant $tenant)
    {
        $agency = auth()->user()->agency;
        
        // Check if tenant belongs to this agency
        if ($tenant->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to this tenant.');
        }

        // Check if already moved out
        if ($tenant->status === 'ended') {
            return back()->with('error', 'This tenant has already moved out.');
        }

        try {
            $tenant->markAsMovedOut();

            // Send notification to tenant
            $this->notificationService->system([
                'title' => 'Tenancy Ended',
                'message' => "Your tenancy at {$tenant->property->headline} has been marked as ended. Thank you for being a tenant with us. We will process your bond refund shortly.",
                'category' => 'general',
                'priority' => 'high',
                'recipient_id' => $tenant->user_id,
                'metadata' => [
                    'tenant_id' => $tenant->id,
                    'property_id' => $tenant->property_id,
                ],
            ]);

            return back()->with('success', 'Tenant marked as moved out successfully. Notification sent.');
            
        } catch (\Exception $e) {
            \Log::error('Mark as moved out failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to update tenant status. Please try again.');
        }
    }

    /**
     * Record notice given
     */
    public function giveNotice(Request $request, Tenant $tenant)
    {
        $agency = auth()->user()->agency;
        
        // Check if tenant belongs to this agency
        if ($tenant->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to this tenant.');
        }

        // Check status
        if (!in_array($tenant->status, ['pending_move_in', 'active'])) {
            return back()->with('error', 'Cannot give notice for this tenant status.');
        }

        $validated = $request->validate([
            'intended_vacate_date' => 'required|date|after:today',
        ]);

        try {
            $tenant->giveNotice($validated['intended_vacate_date']);

            // Send notification to tenant
            $this->notificationService->system([
                'title' => 'Notice to Vacate Recorded',
                'message' => "We have recorded your notice to vacate {$tenant->property->headline}. Your intended vacate date is " . \Carbon\Carbon::parse($validated['intended_vacate_date'])->format('F d, Y') . ". Please ensure the property is in good condition for the final inspection.",
                'category' => 'general',
                'priority' => 'high',
                'recipient_id' => $tenant->user_id,
                'metadata' => [
                    'tenant_id' => $tenant->id,
                    'intended_vacate_date' => $validated['intended_vacate_date'],
                ],
            ]);

            return back()->with('success', 'Notice to vacate recorded successfully. Notification sent to tenant.');
            
        } catch (\Exception $e) {
            \Log::error('Give notice failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to record notice. Please try again.');
        }
    }

    /**
     * Mark bond as paid
     */
    public function markBondPaid(Request $request, Tenant $tenant)
    {
        $agency = auth()->user()->agency;
        
        // Check if tenant belongs to this agency
        if ($tenant->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to this tenant.');
        }

        // Check if already paid
        if ($tenant->bond_paid) {
            return back()->with('error', 'Bond has already been marked as paid.');
        }

        $validated = $request->validate([
            'bond_reference' => 'nullable|string|max:255',
            'bond_paid_date' => 'nullable|date',
        ]);

        try {
            $tenant->update([
                'bond_paid' => true,
                'bond_paid_date' => $validated['bond_paid_date'] ?? now(),
                'bond_reference' => $validated['bond_reference'] ?? null,
            ]);

            // Send notification to tenant
            $this->notificationService->system([
                'title' => 'Bond Payment Received',
                'message' => "We have received your bond payment of $" . number_format($tenant->bond_amount, 2) . " for {$tenant->property->headline}. " . 
                            ($validated['bond_reference'] ? "Reference: {$validated['bond_reference']}" : "Thank you for your payment."),
                'category' => 'payment',
                'priority' => 'medium',
                'recipient_id' => $tenant->user_id,
                'metadata' => [
                    'tenant_id' => $tenant->id,
                    'bond_amount' => $tenant->bond_amount,
                    'bond_reference' => $validated['bond_reference'] ?? null,
                ],
            ]);

            return back()->with('success', 'Bond marked as paid successfully. Notification sent to tenant.');
            
        } catch (\Exception $e) {
            \Log::error('Mark bond paid failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to update bond status. Please try again.');
        }
    }

    /**
     * Update next payment due date
     */
    public function updatePaymentDue(Tenant $tenant)
    {
        $agency = auth()->user()->agency;
        
        // Check if tenant belongs to this agency
        if ($tenant->agency_id !== $agency->id) {
            abort(403, 'Unauthorized access to this tenant.');
        }

        try {
            $tenant->updateNextPaymentDue();

            return back()->with('success', 'Next payment due date updated successfully.');
            
        } catch (\Exception $e) {
            \Log::error('Update payment due failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to update payment due date. Please try again.');
        }
    }
}