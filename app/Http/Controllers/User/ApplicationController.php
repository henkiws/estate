<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Display user's applications
     */
    public function index()
    {
        $user = Auth::user();
        
        $applications = $user->propertyApplications()
            ->with(['property.agency', 'property.featuredImage'])
            ->latest()
            ->paginate(10);
        
        return view('user.applications.index', compact('applications'));
    }
    
    /**
     * Show application form
     */
    public function create($code)
    {
        $user = Auth::user();
        
        // Find property
        $property = Property::where('property_code', $code)
            ->where('is_published', true)
            ->where('listing_type', 'rent') // Only for rental properties
            ->where('status', 'active')
            ->firstOrFail();
        
        // Check if user already applied
        $existingApplication = PropertyApplication::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();
        
        if ($existingApplication) {
            return redirect()
                ->route('user.applications.show', $existingApplication)
                ->with('info', 'You have already applied for this property.');
        }
        
        return view('user.applications.create', compact('property'));
    }
    
    /**
     * Store application
     */
    public function store(Request $request, $code)
    {
        $user = Auth::user();
        
        // Find property
        $property = Property::where('property_code', $code)
            ->where('is_published', true)
            ->where('listing_type', 'rent')
            ->firstOrFail();
        
        // Validate
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'current_address' => 'required|string|max:500',
            'move_in_date' => 'required|date|after:today',
            'number_of_occupants' => 'required|integer|min:1|max:20',
            'has_pets' => 'required|boolean',
            'pet_details' => 'nullable|string|max:500',
            'employment_status' => 'required|in:employed,self_employed,student,retired,unemployed',
            'employer_name' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'annual_income' => 'required|numeric|min:0',
            'references' => 'nullable|array|max:3',
            'references.*.name' => 'required_with:references|string|max:100',
            'references.*.relationship' => 'required_with:references|string|max:100',
            'references.*.phone' => 'required_with:references|string|max:20',
            'references.*.email' => 'nullable|email|max:255',
            'additional_information' => 'nullable|string|max:2000',
            'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);
        
        try {
            DB::beginTransaction();
            
            // Handle document uploads
            $documents = [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $path = $file->store('applications', 'public');
                    $documents[] = [
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                    ];
                }
            }
            
            // Create application
            $application = PropertyApplication::create([
                'user_id' => $user->id,
                'property_id' => $property->id,
                'agency_id' => $property->agency_id,
                'status' => 'pending',
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'current_address' => $validated['current_address'],
                'move_in_date' => $validated['move_in_date'],
                'number_of_occupants' => $validated['number_of_occupants'],
                'has_pets' => $validated['has_pets'],
                'pet_details' => $validated['pet_details'] ?? null,
                'employment_status' => $validated['employment_status'],
                'employer_name' => $validated['employer_name'] ?? null,
                'job_title' => $validated['job_title'] ?? null,
                'annual_income' => $validated['annual_income'],
                'references' => $validated['references'] ?? null,
                'additional_information' => $validated['additional_information'] ?? null,
                'documents' => !empty($documents) ? $documents : null,
                'submitted_at' => now(),
            ]);
            
            // Increment property enquiry count
            $property->incrementEnquiries();
            
            DB::commit();
            
            // TODO: Send email notification to agency
            
            return redirect()
                ->route('user.applications.show', $application)
                ->with('success', 'Application submitted successfully! The agency will review it soon.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Clean up uploaded files if any
            if (!empty($documents)) {
                foreach ($documents as $doc) {
                    Storage::disk('public')->delete($doc['path']);
                }
            }
            
            return back()
                ->withInput()
                ->with('error', 'Failed to submit application. Please try again.');
        }
    }
    
    /**
     * Show single application
     */
    public function show(PropertyApplication $application)
    {
        $user = Auth::user();
        
        // Ensure user owns this application
        if ($application->user_id !== $user->id) {
            abort(403, 'Unauthorized access to application.');
        }
        
        $application->load(['property.agency', 'property.featuredImage']);
        
        return view('user.applications.show', compact('application'));
    }
    
    /**
     * Withdraw application
     */
    public function withdraw(PropertyApplication $application)
    {
        $user = Auth::user();
        
        // Ensure user owns this application
        if ($application->user_id !== $user->id) {
            abort(403);
        }
        
        // Can only withdraw pending applications
        if ($application->status !== 'pending') {
            return back()->with('error', 'Cannot withdraw this application.');
        }
        
        $application->withdraw();
        
        return back()->with('success', 'Application withdrawn successfully.');
    }
}