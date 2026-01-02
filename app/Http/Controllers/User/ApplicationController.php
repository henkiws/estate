<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PropertyApplication;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    /**
     * Display a listing of user's applications
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get view mode (grid or list)
        $viewMode = $request->get('view', 'grid');
        
        // Build query
        $query = PropertyApplication::with(['property', 'agency'])
            ->where('user_id', $user->id);
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('property', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('street_address', 'like', "%{$search}%")
                  ->orWhere('suburb', 'like', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->filled('status') && $request->get('status') !== 'all') {
            $status = $request->get('status');
            
            if ($status === 'submitted') {
                // "submitted" means pending or under_review
                $query->whereIn('status', ['pending', 'under_review']);
            } else {
                $query->where('status', $status);
            }
        }
        
        // Sort
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'status':
                $query->orderBy('status', 'asc')->orderBy('created_at', 'desc');
                break;
            case 'recent':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        // Get paginated results
        $applications = $query->paginate(12);
        
        // Get status counts for filters
        $counts = [
            'all' => PropertyApplication::where('user_id', $user->id)->count(),
            'draft' => PropertyApplication::where('user_id', $user->id)->where('status', 'draft')->count(),
            'submitted' => PropertyApplication::where('user_id', $user->id)->whereIn('status', ['pending', 'under_review'])->count(),
            'under_review' => PropertyApplication::where('user_id', $user->id)->where('status', 'under_review')->count(),
            'approved' => PropertyApplication::where('user_id', $user->id)->where('status', 'approved')->count(),
            'rejected' => PropertyApplication::where('user_id', $user->id)->where('status', 'rejected')->count(),
            'withdrawn' => PropertyApplication::where('user_id', $user->id)->where('status', 'withdrawn')->count(),
        ];
        
        return view('user.applications.index', compact('applications', 'viewMode', 'counts'));
    }

    /**
     * Show the form for creating a new application
     */
    public function create(Request $request)
    {
        $propertyId = $request->get('property_id');
        
        if (!$propertyId) {
            return redirect()->route('properties.index')
                ->with('error', 'Please select a property to apply for.');
        }
        
        // Check if property exists and is active
        $property = Property::where('id', $propertyId)
            ->where('status', 'active')
            ->firstOrFail();
        
        // Check if user already has a pending/approved application for this property
        $existingApplication = PropertyApplication::where('user_id', Auth::id())
            ->where('property_id', $propertyId)
            ->whereIn('status', ['pending', 'under_review', 'approved'])
            ->first();
        
        if ($existingApplication) {
            return redirect()->route('user.applications.show', $existingApplication->id)
                ->with('info', 'You already have an application for this property.');
        }
        
        // TODO: Check if user profile is complete (optional)
        // if (!Auth::user()->hasCompletedProfile()) {
        //     return redirect()->route('user.profile.complete')
        //         ->with('warning', 'Please complete your profile before applying for properties.');
        // }
        
        return view('user.applications.create', compact('property'));
    }

    /**
     * Store a newly created application
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'move_in_date' => 'required|date|after:today',
            'lease_term' => 'required|integer|min:1|max:24',
            'number_of_occupants' => 'required|integer|min:1|max:10',
            'occupants_details' => 'nullable|array',
            'occupants_details.*.first_name' => 'required_with:occupants_details|string|max:255',
            'occupants_details.*.last_name' => 'required_with:occupants_details|string|max:255',
            'occupants_details.*.relationship' => 'required_with:occupants_details|string|max:255',
            'occupants_details.*.age' => 'nullable|integer|min:0|max:120',
            'occupants_details.*.email' => 'nullable|email|max:255',
            'special_requests' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
            'submit_type' => 'required|in:draft,submit',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Get property to find agency_id
            $property = Property::findOrFail($validated['property_id']);
            
            // Check property is still active
            if ($property->status !== 'active') {
                return back()->withInput()
                    ->with('error', 'Sorry, this property is no longer active.');
            }
            
            // Determine status based on submit type
            $status = $validated['submit_type'] === 'submit' ? 'pending' : 'draft';
            
            // Get user info
            $user = Auth::user();
            
            // Create application
            $application = PropertyApplication::create([
                'user_id' => $user->id,
                'property_id' => $validated['property_id'],
                'agency_id' => $property->agency_id,
                'status' => $status,
                'first_name' => $user->profile->first_name,
                'last_name' => $user->profile->last_name,
                'email' => $user->email,
                'phone' => $user->profile->phone,
                'date_of_birth' => $user->profile->date_of_birth,
                'phone' => 0,
                'current_address' => '',
                'annual_income' => 0,
                
                // Application details
                'move_in_date' => $validated['move_in_date'],
                'lease_term' => $validated['lease_term'],
                'number_of_occupants' => $validated['number_of_occupants'],
                'occupants_details' => $validated['occupants_details'] ?? null,
                'special_requests' => $validated['special_requests'] ?? null,
                'notes' => $validated['notes'] ?? null,
                
                // Timestamps
                'submitted_at' => now(),
            ]);
            
            DB::commit();
            
            if ($status === 'pending') {
                // TODO: Send notification to agency
                // TODO: Send confirmation email to user
                
                return redirect()->route('user.applications.show', $application->id)
                    ->with('success', 'Application submitted successfully! The agency will review your application shortly.');
            } else {
                return redirect()->route('user.applications.show', $application->id)
                    ->with('success', 'Application saved as draft. You can complete and submit it later.');
            }
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Application submission failed: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Failed to submit application. Please try again.');
        }
    }

    /**
     * Display the specified application
     */
    public function show($id)
    {
        $application = PropertyApplication::with([
                'property',
                'agency',
                'user'
            ])
            ->where('id', $id)
            ->where('user_id', Auth::id()) // Ensure user can only view their own applications
            ->firstOrFail();
        
        return view('user.applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified application
     */
    public function edit($id)
    {
        $application = PropertyApplication::with('property')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['draft', 'pending']) // Allow editing drafts and pending
            ->firstOrFail();
        
        return view('user.applications.edit', compact('application'));
    }

    /**
     * Update the specified application
     */
    public function update(Request $request, $id)
    {
        $application = PropertyApplication::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['draft', 'pending'])
            ->firstOrFail();
        
        $validated = $request->validate([
            'move_in_date' => 'required|date|after:today',
            'lease_term' => 'required|integer|min:1|max:24',
            'number_of_occupants' => 'required|integer|min:1|max:10',
            'occupants_details' => 'nullable|array',
            'occupants_details.*.first_name' => 'required_with:occupants_details|string|max:255',
            'occupants_details.*.last_name' => 'required_with:occupants_details|string|max:255',
            'occupants_details.*.relationship' => 'required_with:occupants_details|string|max:255',
            'occupants_details.*.age' => 'nullable|integer|min:0|max:120',
            'special_requests' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
            'submit_type' => 'required|in:draft,submit',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Determine new status
            $newStatus = $validated['submit_type'] === 'submit' ? 'pending' : 'draft';
            
            // Update application
            $application->update([
                'status' => $newStatus,
                'move_in_date' => $validated['move_in_date'],
                'lease_term' => $validated['lease_term'],
                'number_of_occupants' => $validated['number_of_occupants'],
                'occupants_details' => $validated['occupants_details'] ?? null,
                'special_requests' => $validated['special_requests'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'submitted_at' => ($newStatus === 'pending' && !$application->submitted_at) ? now() : $application->submitted_at,
            ]);
            
            DB::commit();
            
            if ($newStatus === 'pending') {
                return redirect()->route('user.applications.show', $application->id)
                    ->with('success', 'Application submitted successfully!');
            } else {
                return redirect()->route('user.applications.show', $application->id)
                    ->with('success', 'Application updated successfully.');
            }
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Application update failed: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Failed to update application. Please try again.');
        }
    }

    /**
     * Withdraw the specified application
     */
    public function withdraw($id)
    {
        $application = PropertyApplication::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'under_review'])
            ->firstOrFail();
        
        $application->update([
            'status' => 'withdrawn',
            'withdrawn_at' => now(),
        ]);
        
        return redirect()->route('user.applications.index')
            ->with('success', 'Application withdrawn successfully.');
    }

    /**
     * Remove the specified application (soft delete)
     */
    public function destroy($id)
    {
        $application = PropertyApplication::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'draft') // Only allow deleting drafts
            ->firstOrFail();
        
        $application->delete();
        
        return redirect()->route('user.applications.index')
            ->with('success', 'Draft application deleted successfully.');
    }
}