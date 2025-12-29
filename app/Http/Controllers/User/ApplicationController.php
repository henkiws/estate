<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PropertyApplication;
use App\Models\CoApplicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    /**
     * Display a listing of user's applications
     */
    public function index()
    {
        $applications = PropertyApplication::with(['property.images', 'agency'])
            ->forUser(Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('user.applications.index', compact('applications'));
    }

    /**
     * Show the form for creating a new application
     */
    public function create(Request $request)
    {
        $propertyId = $request->get('property_id');
        
        // Check if property exists and is available
        $property = \App\Models\Property::findOrFail($propertyId);
        
        // Check if user already has a pending application for this property
        $existingApplication = PropertyApplication::where('user_id', Auth::id())
            ->where('property_id', $propertyId)
            ->whereIn('status', ['pending', 'approved'])
            ->first();
        
        if ($existingApplication) {
            return redirect()->route('user.applications.show', $existingApplication->id)
                ->with('info', 'You already have an application for this property.');
        }
        
        return view('user.applications.create', compact('property'));
    }

    /**
     * Store a newly created application
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'current_address' => 'required|string',
            'move_in_date' => 'required|date',
            'lease_duration' => 'nullable|integer|min:1|max:60',
            'inspection_confirmed' => 'required|boolean',
            'inspection_date' => 'nullable|date|required_if:inspection_confirmed,true',
            'number_of_occupants' => 'required|integer|min:1',
            'has_pets' => 'required|boolean',
            'pet_details' => 'nullable|string|required_if:has_pets,true',
            'employment_status' => 'required|string',
            'employer_name' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'annual_income' => 'required|numeric|min:0',
            'references' => 'nullable|array',
            'additional_information' => 'nullable|string',
            'documents' => 'nullable|array',
            // Co-applicants
            'co_applicants' => 'nullable|array',
            'co_applicants.*.first_name' => 'required|string|max:255',
            'co_applicants.*.last_name' => 'required|string|max:255',
            'co_applicants.*.email' => 'required|email|max:255',
            'co_applicants.*.phone' => 'required|string|max:20',
            'co_applicants.*.date_of_birth' => 'required|date',
            'co_applicants.*.relationship_to_applicant' => 'nullable|string|max:255',
            'co_applicants.*.employment_status' => 'nullable|string|max:255',
            'co_applicants.*.employer_name' => 'nullable|string|max:255',
            'co_applicants.*.annual_income' => 'nullable|numeric|min:0',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Get property to find agency_id
            $property = \App\Models\Property::findOrFail($validated['property_id']);
            
            // Create main application
            $application = PropertyApplication::create([
                'user_id' => Auth::id(),
                'property_id' => $validated['property_id'],
                'agency_id' => $property->agency_id,
                'status' => 'pending',
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'date_of_birth' => $validated['date_of_birth'],
                'current_address' => $validated['current_address'],
                'move_in_date' => $validated['move_in_date'],
                'lease_duration' => $validated['lease_duration'] ?? null,
                'inspection_confirmed' => $validated['inspection_confirmed'],
                'inspection_date' => $validated['inspection_date'] ?? null,
                'number_of_occupants' => $validated['number_of_occupants'],
                'has_pets' => $validated['has_pets'],
                'pet_details' => $validated['pet_details'] ?? null,
                'employment_status' => $validated['employment_status'],
                'employer_name' => $validated['employer_name'] ?? null,
                'job_title' => $validated['job_title'] ?? null,
                'annual_income' => $validated['annual_income'],
                'references' => $validated['references'] ?? null,
                'additional_information' => $validated['additional_information'] ?? null,
                'documents' => $validated['documents'] ?? null,
                'submitted_at' => now(),
            ]);
            
            // Create co-applicants if provided
            if (!empty($validated['co_applicants'])) {
                foreach ($validated['co_applicants'] as $coApplicantData) {
                    CoApplicant::create([
                        'property_application_id' => $application->id,
                        'first_name' => $coApplicantData['first_name'],
                        'last_name' => $coApplicantData['last_name'],
                        'email' => $coApplicantData['email'],
                        'phone' => $coApplicantData['phone'],
                        'date_of_birth' => $coApplicantData['date_of_birth'],
                        'relationship_to_applicant' => $coApplicantData['relationship_to_applicant'] ?? null,
                        'employment_status' => $coApplicantData['employment_status'] ?? null,
                        'employer_name' => $coApplicantData['employer_name'] ?? null,
                        'annual_income' => $coApplicantData['annual_income'] ?? null,
                    ]);
                }
            }
            
            DB::commit();
            
            return redirect()->route('user.applications.show', $application->id)
                ->with('success', 'Application submitted successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
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
                'property.images',
                'property.agency',
                'agency',
                'user',
                'coApplicants' // Load co-applicants
            ])
            ->where('id', $id)
            ->forUser(Auth::id()) // Ensure user can only view their own applications
            ->firstOrFail();
        
        // Get group members (co-applicants)
        $groupMembers = $application->coApplicants;
        
        return view('user.applications.show', compact('application', 'groupMembers'));
    }

    /**
     * Show the form for editing the specified application
     */
    public function edit($id)
    {
        $application = PropertyApplication::with(['property', 'coApplicants'])
            ->where('id', $id)
            ->forUser(Auth::id())
            ->where('status', 'pending') // Only allow editing pending applications
            ->firstOrFail();
        
        return view('user.applications.edit', compact('application'));
    }

    /**
     * Update the specified application
     */
    public function update(Request $request, $id)
    {
        $application = PropertyApplication::where('id', $id)
            ->forUser(Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'current_address' => 'required|string',
            'move_in_date' => 'required|date',
            'lease_duration' => 'nullable|integer|min:1|max:60',
            'inspection_confirmed' => 'required|boolean',
            'inspection_date' => 'nullable|date|required_if:inspection_confirmed,true',
            'number_of_occupants' => 'required|integer|min:1',
            'has_pets' => 'required|boolean',
            'pet_details' => 'nullable|string',
            'employment_status' => 'required|string',
            'employer_name' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'annual_income' => 'required|numeric|min:0',
            'references' => 'nullable|array',
            'additional_information' => 'nullable|string',
            'documents' => 'nullable|array',
        ]);
        
        $application->update($validated);
        
        return redirect()->route('user.applications.show', $application->id)
            ->with('success', 'Application updated successfully!');
    }

    /**
     * Withdraw the specified application
     */
    public function withdraw($id)
    {
        $application = PropertyApplication::where('id', $id)
            ->forUser(Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();
        
        $application->withdraw();
        
        return redirect()->route('user.applications.index')
            ->with('success', 'Application withdrawn successfully.');
    }

    /**
     * Remove the specified application (soft delete)
     */
    public function destroy($id)
    {
        $application = PropertyApplication::where('id', $id)
            ->forUser(Auth::id())
            ->firstOrFail();
        
        $application->delete();
        
        return redirect()->route('user.applications.index')
            ->with('success', 'Application deleted successfully.');
    }
}