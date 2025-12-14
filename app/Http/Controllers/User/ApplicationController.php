<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Display a listing of applications
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Application::with(['property', 'property.agency'])
            ->forUser($user->id)
            ->recent();
        
        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }
        
        // Search by property
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        // Sort
        $sortBy = $request->get('sort', 'recent');
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'status':
                $query->orderBy('status', 'asc')->orderBy('created_at', 'desc');
                break;
            default:
                $query->recent();
        }
        
        $applications = $query->paginate(12);
        
        // Get counts for filters
        $counts = [
            'all' => Application::forUser($user->id)->count(),
            'draft' => Application::forUser($user->id)->byStatus('draft')->count(),
            'submitted' => Application::forUser($user->id)->byStatus('submitted')->count(),
            'under_review' => Application::forUser($user->id)->byStatus('under_review')->count(),
            'approved' => Application::forUser($user->id)->byStatus('approved')->count(),
            'rejected' => Application::forUser($user->id)->byStatus('rejected')->count(),
            'withdrawn' => Application::forUser($user->id)->byStatus('withdrawn')->count(),
        ];
        
        $viewMode = $request->get('view', 'grid'); // grid or list
        
        return view('user.applications.index', compact('applications', 'counts', 'viewMode'));
    }

    /**
     * Show the form for creating a new application
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        
        // Check if user profile is approved
        if (!$user->profile || !$user->profile->isComplete()) {
            return redirect()->route('user.profile.complete')
                ->with('error', 'Please complete your profile before applying for properties.');
        }
        
        // Get property if specified
        $property = null;
        if ($request->filled('property_id')) {
            $property = Property::with('agency')->findOrFail($request->property_id);
            
            // Check if user already has an active application for this property
            $existingApplication = Application::forUser($user->id)
                ->where('property_id', $property->id)
                ->active()
                ->first();
            
            if ($existingApplication) {
                return redirect()->route('user.applications.show', $existingApplication)
                    ->with('info', 'You already have an active application for this property.');
            }
        }
        
        return view('user.applications.create', compact('property'));
    }

    /**
     * Store a newly created application
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'move_in_date' => 'required|date|after:today',
            'lease_term' => 'required|integer|min:1|max:24',
            'number_of_occupants' => 'required|integer|min:1|max:10',
            'occupants_details' => 'nullable|array',
            'occupants_details.*.name' => 'required|string|max:255',
            'occupants_details.*.relationship' => 'required|string|max:255',
            'occupants_details.*.age' => 'nullable|integer|min:0|max:120',
            'special_requests' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
            'submit_type' => 'required|in:draft,submit',
        ]);
        
        // Check if user already has an active application
        $existingApplication = Application::forUser($user->id)
            ->where('property_id', $validated['property_id'])
            ->active()
            ->first();
        
        if ($existingApplication) {
            return redirect()->route('user.applications.show', $existingApplication)
                ->with('error', 'You already have an active application for this property.');
        }
        
        // Create application
        $application = Application::create([
            'user_id' => $user->id,
            'property_id' => $validated['property_id'],
            'move_in_date' => $validated['move_in_date'],
            'lease_term' => $validated['lease_term'],
            'number_of_occupants' => $validated['number_of_occupants'],
            'occupants_details' => $validated['occupants_details'] ?? null,
            'special_requests' => $validated['special_requests'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'draft',
        ]);
        
        // Submit if requested
        if ($validated['submit_type'] === 'submit') {
            $application->submit();
            
            return redirect()->route('user.applications.show', $application)
                ->with('success', 'Application submitted successfully! You will be notified when it is reviewed.');
        }
        
        return redirect()->route('user.applications.show', $application)
            ->with('success', 'Application draft saved successfully.');
    }

    /**
     * Display the specified application
     */
    public function show(Application $application)
    {
        $user = Auth::user();
        
        // Ensure user owns this application
        if ($application->user_id !== $user->id) {
            abort(403);
        }
        
        $application->load(['property', 'property.agency', 'property.images']);
        
        return view('user.applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified application
     */
    public function edit(Application $application)
    {
        $user = Auth::user();
        
        // Ensure user owns this application
        if ($application->user_id !== $user->id) {
            abort(403);
        }
        
        // Can only edit drafts
        if (!$application->canEdit()) {
            return redirect()->route('user.applications.show', $application)
                ->with('error', 'You can only edit draft applications.');
        }
        
        $property = $application->property;
        
        return view('user.applications.edit', compact('application', 'property'));
    }

    /**
     * Update the specified application
     */
    public function update(Request $request, Application $application)
    {
        $user = Auth::user();
        
        // Ensure user owns this application
        if ($application->user_id !== $user->id) {
            abort(403);
        }
        
        // Can only edit drafts
        if (!$application->canEdit()) {
            return redirect()->route('user.applications.show', $application)
                ->with('error', 'You can only edit draft applications.');
        }
        
        $validated = $request->validate([
            'move_in_date' => 'required|date|after:today',
            'lease_term' => 'required|integer|min:1|max:24',
            'number_of_occupants' => 'required|integer|min:1|max:10',
            'occupants_details' => 'nullable|array',
            'occupants_details.*.name' => 'required|string|max:255',
            'occupants_details.*.relationship' => 'required|string|max:255',
            'occupants_details.*.age' => 'nullable|integer|min:0|max:120',
            'special_requests' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
            'submit_type' => 'required|in:draft,submit',
        ]);
        
        $application->update([
            'move_in_date' => $validated['move_in_date'],
            'lease_term' => $validated['lease_term'],
            'number_of_occupants' => $validated['number_of_occupants'],
            'occupants_details' => $validated['occupants_details'] ?? null,
            'special_requests' => $validated['special_requests'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);
        
        // Submit if requested
        if ($validated['submit_type'] === 'submit') {
            $application->submit();
            
            return redirect()->route('user.applications.show', $application)
                ->with('success', 'Application submitted successfully!');
        }
        
        return redirect()->route('user.applications.show', $application)
            ->with('success', 'Application updated successfully.');
    }

    /**
     * Withdraw the application
     */
    public function withdraw(Application $application)
    {
        $user = Auth::user();
        
        // Ensure user owns this application
        if ($application->user_id !== $user->id) {
            abort(403);
        }
        
        if (!$application->canWithdraw()) {
            return redirect()->route('user.applications.show', $application)
                ->with('error', 'This application cannot be withdrawn.');
        }
        
        $application->withdraw();
        
        return redirect()->route('user.applications.index')
            ->with('success', 'Application withdrawn successfully.');
    }

    /**
     * Submit a draft application
     */
    public function submit(Application $application)
    {
        $user = Auth::user();
        
        // Ensure user owns this application
        if ($application->user_id !== $user->id) {
            abort(403);
        }
        
        if (!$application->isDraft()) {
            return redirect()->route('user.applications.show', $application)
                ->with('error', 'Only draft applications can be submitted.');
        }
        
        $application->submit();
        
        return redirect()->route('user.applications.show', $application)
            ->with('success', 'Application submitted successfully!');
    }
}