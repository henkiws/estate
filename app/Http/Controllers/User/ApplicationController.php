<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PropertyApplication;
use App\Models\Property;
use App\Models\Favorite;
use App\Models\Application;
use App\Models\SavedProperty;
use App\Models\UserProfile;
use App\Models\UserAddress;
use App\Models\UserEmployment;
use App\Models\UserIncome;
use App\Models\UserIdentification;
use App\Models\UserPet;
use App\Models\InspectionBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        $user = Auth::user();
        
        try {
            DB::beginTransaction();
            
            // ============ VALIDATION ============
            $validated = $request->validate([
                // Property & Application basics
                'property_id' => 'required|exists:properties,id',
                'move_in_date' => 'required|date|after:today',
                'lease_term' => 'required|integer|min:1|max:24',
                'property_inspection' => 'required|in:yes,no',
                'inspection_date' => 'required_if:property_inspection,yes|nullable|date|before_or_equal:today',
                
                // Step 1: Personal Details & Contact
                'title' => 'required|string|in:Mr,Mrs,Ms,Miss,Dr,Prof,Other',
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'surname' => 'nullable|string|max:255',
                'date_of_birth' => 'required|date|before:' . now()->subYears(18)->format('Y-m-d'),
                'email' => 'required|email|max:255',
                'mobile_country_code' => 'required|string',
                'mobile_number' => 'required|string|max:20',
                
                // Step 2: Address History
                'addresses' => 'required|array|min:1',
                'addresses.*.living_arrangement' => 'required|string|in:owner,renting_agent,renting_privately,with_parents,sharing,other',
                'addresses.*.address' => 'required|string|max:500',
                'addresses.*.years_lived' => 'required|integer|min:0|max:100',
                'addresses.*.months_lived' => 'required|integer|min:0|max:11',
                'addresses.*.reason_for_leaving' => 'nullable|string|max:1000',
                'addresses.*.different_postal_address' => 'nullable|boolean',
                'addresses.*.postal_code' => 'nullable|string|max:500',
                'addresses.*.is_current' => 'nullable|boolean',
                
                // Step 3: Employment
                'has_employment' => 'nullable|boolean',
                'employments' => 'nullable|array',
                'employments.*.company_name' => 'required_if:has_employment,true|nullable|string|max:255',
                'employments.*.address' => 'required_if:has_employment,true|nullable|string|max:500',
                'employments.*.position' => 'required_if:has_employment,true|nullable|string|max:255',
                'employments.*.gross_annual_salary' => 'required_if:has_employment,true|nullable|numeric|min:0|max:9999999.99',
                'employments.*.manager_full_name' => 'required_if:has_employment,true|nullable|string|max:255',
                'employments.*.contact_number' => 'required_if:has_employment,true|nullable|string|max:20',
                'employments.*.email' => 'required_if:has_employment,true|nullable|email|max:255',
                'employments.*.start_date' => 'required_if:has_employment,true|nullable|date|before_or_equal:today',
                'employments.*.still_employed' => 'nullable|boolean',
                'employments.*.end_date' => 'nullable|date|before_or_equal:today',
                'employments.*.employment_letter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                
                // Step 4: Income/Finances
                'incomes' => 'required|array|min:1',
                'incomes.*.source_of_income' => 'required|string|in:full_time_employment,part_time_employment,casual_employment,self_employed,centrelink,pension,investment,savings,other',
                'incomes.*.net_weekly_amount' => 'required|numeric|min:0|max:999999.99',
                'incomes.*.bank_statement' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                
                // Step 5: Identity Documents
                'identifications' => 'required|array|min:1',
                'identifications.*.identification_type' => 'required|string|in:australian_drivers_licence,passport,birth_certificate,medicare,other',
                'identifications.*.document_number' => 'nullable|string|max:100',
                'identifications.*.document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'identifications.*.expiry_date' => 'nullable|date|after:today',
                
                // Step 6: Emergency Contact (optional)
                'has_emergency_contact' => 'nullable|boolean',
                'emergency_contact_name' => 'nullable|required_if:has_emergency_contact,1|string|max:255',
                'emergency_contact_relationship' => 'nullable|required_if:has_emergency_contact,1|string|max:255',
                'emergency_contact_country_code' => 'nullable|required_if:has_emergency_contact,1|string',
                'emergency_contact_number' => 'nullable|required_if:has_emergency_contact,1|string|max:20',
                'emergency_contact_email' => 'nullable|required_if:has_emergency_contact,1|email|max:255',
                
                // Step 7: Household
                'number_of_occupants' => 'required|integer|min:1|max:10',
                'occupants_details' => 'required|array|min:1',
                'occupants_details.*.first_name' => 'required|string|max:255',
                'occupants_details.*.last_name' => 'required|string|max:255',
                'occupants_details.*.relationship' => 'required|string|max:255',
                'occupants_details.*.age' => 'nullable|integer|min:0|max:120',
                'occupants_details.0.age' => 'required|integer|min:18|max:120',
                'occupants_details.*.email' => 'nullable|email|max:255',
                
                // Step 8: Pets (optional)
                'has_pets' => 'nullable|boolean',
                'pets' => 'nullable|array',
                'pets.*.type' => 'required_with:pets|string|in:dog,cat,bird,fish,rabbit,other',
                'pets.*.breed' => 'required_with:pets|string|max:255',
                'pets.*.desexed' => 'required_with:pets|boolean',
                'pets.*.size' => 'required_with:pets|string|in:small,medium,large',
                'pets.*.registration_number' => 'nullable|string|max:100',
                'pets.*.document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                
                // Step 9: Utility Connections (optional)
                'utility_electricity' => 'nullable|boolean',
                'utility_gas' => 'nullable|boolean',
                'utility_internet' => 'nullable|boolean',
                
                // Step 10: Additional Notes (optional)
                'special_requests' => 'nullable|string|max:1000',
                'notes' => 'nullable|string|max:1000',
                
                // Step 11: Terms & Conditions (required) - just validate, don't store
                'accept_terms' => 'required|accepted',
                'declare_accuracy' => 'required|accepted',
                'consent_privacy' => 'required|accepted',
            ]);
            
            // Get property and validate
            $property = Property::findOrFail($validated['property_id']);
            
            if ($property->status !== 'active') {
                throw new \Exception('Sorry, this property is no longer available for applications.');
            }
            
            // ============ UPDATE USER PROFILE ============
            
            // 1. Update/Create Profile
            $profile = $user->profile ?: new UserProfile();
            $profile->user_id = $user->id;
            $profile->title = $validated['title'];
            $profile->first_name = $validated['first_name'];
            $profile->middle_name = $validated['middle_name'] ?? null;
            $profile->last_name = $validated['last_name'];
            $profile->surname = $validated['surname'] ?? null;
            $profile->date_of_birth = $validated['date_of_birth'];
            $profile->mobile_country_code = $validated['mobile_country_code'];
            $profile->mobile_number = $validated['mobile_number'];
            
            // Emergency Contact
            $profile->has_emergency_contact = $validated['has_emergency_contact'] ?? false;
            if ($profile->has_emergency_contact) {
                $profile->emergency_contact_name = $validated['emergency_contact_name'];
                $profile->emergency_contact_relationship = $validated['emergency_contact_relationship'];
                $profile->emergency_contact_country_code = $validated['emergency_contact_country_code'];
                $profile->emergency_contact_number = $validated['emergency_contact_number'];
                $profile->emergency_contact_email = $validated['emergency_contact_email'];
            }
            
            $profile->save();
            
            // 2. Update Addresses
            $user->addresses()->delete();
            foreach ($validated['addresses'] as $addressData) {
                $address = new UserAddress();
                $address->user_id = $user->id;
                $address->living_arrangement = $addressData['living_arrangement'];
                $address->address = $addressData['address'];
                $address->years_lived = $addressData['years_lived'];
                $address->months_lived = $addressData['months_lived'];
                $address->reason_for_leaving = $addressData['reason_for_leaving'] ?? null;
                $address->different_postal_address = $addressData['different_postal_address'] ?? false;
                $address->postal_code = $addressData['postal_code'] ?? null;
                $address->is_current = $addressData['is_current'] ?? false;
                $address->save();
            }
            
            // 3. Update Employment
            // DON'T delete existing employments, update or create instead
            if ($validated['has_employment'] && isset($validated['employments'])) {
                // Get existing employments
                $existingEmployments = $user->employments->keyBy(function($item, $key) {
                    return $key;
                });
                
                // Delete employments that are no longer in the form
                if (count($validated['employments']) < $existingEmployments->count()) {
                    $user->employments()->skip(count($validated['employments']))->take(PHP_INT_MAX)->each(function($employment) {
                        if ($employment->employment_letter_path) {
                            Storage::disk('public')->delete($employment->employment_letter_path);
                        }
                        $employment->delete();
                    });
                }
                
                foreach ($validated['employments'] as $index => $employmentData) {
                    // Get existing employment or create new
                    $employment = $existingEmployments->get($index) ?: new UserEmployment();
                    $employment->user_id = $user->id;
                    $employment->company_name = $employmentData['company_name'];
                    $employment->address = $employmentData['address'];
                    $employment->position = $employmentData['position'];
                    $employment->gross_annual_salary = $employmentData['gross_annual_salary'];
                    $employment->manager_full_name = $employmentData['manager_full_name'];
                    $employment->contact_number = $employmentData['contact_number'];
                    $employment->email = $employmentData['email'];
                    $employment->start_date = $employmentData['start_date'];
                    $employment->still_employed = $employmentData['still_employed'] ?? false;
                    $employment->end_date = $employmentData['end_date'] ?? null;
                    
                    // Only update file if new file is uploaded
                    if ($request->hasFile("employments.$index.employment_letter")) {
                        // Delete old file if exists
                        if ($employment->employment_letter_path) {
                            Storage::disk('public')->delete($employment->employment_letter_path);
                        }
                        // Upload new file
                        $path = $request->file("employments.$index.employment_letter")
                            ->store('employment-letters', 'public');
                        $employment->employment_letter_path = $path;
                    }
                    // If no new file uploaded, keep existing employment_letter_path (don't modify)
                    
                    $employment->save();
                }
            } else {
                // User unchecked employment, delete all
                foreach ($user->employments as $employment) {
                    if ($employment->employment_letter_path) {
                        Storage::disk('public')->delete($employment->employment_letter_path);
                    }
                }
                $user->employments()->delete();
            }

            // 4. Update Income
            // DON'T delete existing incomes, update or create instead
            $existingIncomes = $user->incomes->keyBy(function($item, $key) {
                return $key;
            });

            // Delete incomes that are no longer in the form
            if (count($validated['incomes']) < $existingIncomes->count()) {
                $user->incomes()->skip(count($validated['incomes']))->take(PHP_INT_MAX)->each(function($income) {
                    if ($income->bank_statement_path) {
                        Storage::disk('public')->delete($income->bank_statement_path);
                    }
                    $income->delete();
                });
            }

            foreach ($validated['incomes'] as $index => $incomeData) {
                // Get existing income or create new
                $income = $existingIncomes->get($index) ?: new UserIncome();
                $income->user_id = $user->id;
                $income->source_of_income = $incomeData['source_of_income'];
                $income->net_weekly_amount = $incomeData['net_weekly_amount'];
                
                // Only update file if new file is uploaded
                if ($request->hasFile("incomes.$index.bank_statement")) {
                    // Delete old file if exists
                    if ($income->bank_statement_path) {
                        Storage::disk('public')->delete($income->bank_statement_path);
                    }
                    // Upload new file
                    $path = $request->file("incomes.$index.bank_statement")
                        ->store('bank-statements', 'public');
                    $income->bank_statement_path = $path;
                }
                // If no new file uploaded, keep existing bank_statement_path (don't modify)
                
                $income->save();
            }

            // 5. Update Identifications
            // DON'T delete existing identifications, update or create instead
            $existingIds = $user->identifications->keyBy(function($item, $key) {
                return $key;
            });

            // Delete identifications that are no longer in the form
            if (count($validated['identifications']) < $existingIds->count()) {
                $user->identifications()->skip(count($validated['identifications']))->take(PHP_INT_MAX)->each(function($identification) {
                    if ($identification->document_path) {
                        Storage::disk('public')->delete($identification->document_path);
                    }
                    $identification->delete();
                });
            }

            foreach ($validated['identifications'] as $index => $idData) {
                // Get existing identification or create new
                $identification = $existingIds->get($index) ?: new UserIdentification();
                $identification->user_id = $user->id;
                $identification->identification_type = $idData['identification_type'];
                
                $pointsMap = [
                    'australian_drivers_licence' => 40,
                    'passport' => 70,
                    'birth_certificate' => 70,
                    'medicare' => 25,
                    'other' => 0,
                ];
                $identification->points = $pointsMap[$idData['identification_type']] ?? 0;
                $identification->document_number = $idData['document_number'] ?? null;
                $identification->expiry_date = $idData['expiry_date'] ?? null;
                
                // Only update file if new file is uploaded
                if ($request->hasFile("identifications.$index.document")) {
                    // Delete old file if exists
                    if ($identification->document_path) {
                        Storage::disk('public')->delete($identification->document_path);
                    }
                    // Upload new file
                    $path = $request->file("identifications.$index.document")
                        ->store('identification-documents', 'public');
                    $identification->document_path = $path;
                }
                // If no new file uploaded, keep existing document_path (don't modify)
                
                $identification->save();
            }

            // 6. Update Pets
            // DON'T delete existing pets, update or create instead
            $hasPets = $validated['has_pets'] ?? false;
            if ($hasPets && isset($validated['pets'])) {
                $existingPets = $user->pets->keyBy(function($item, $key) {
                    return $key;
                });
                
                // Delete pets that are no longer in the form
                if (count($validated['pets']) < $existingPets->count()) {
                    $user->pets()->skip(count($validated['pets']))->take(PHP_INT_MAX)->each(function($pet) {
                        if ($pet->document_path) {
                            Storage::disk('public')->delete($pet->document_path);
                        }
                        $pet->delete();
                    });
                }
                
                foreach ($validated['pets'] as $index => $petData) {
                    // Get existing pet or create new
                    $pet = $existingPets->get($index) ?: new UserPet();
                    $pet->user_id = $user->id;
                    $pet->type = $petData['type'];
                    $pet->breed = $petData['breed'];
                    $pet->desexed = $petData['desexed'];
                    $pet->size = $petData['size'];
                    $pet->registration_number = $petData['registration_number'] ?? null;
                    
                    // Only update file if new file is uploaded
                    if ($request->hasFile("pets.$index.document")) {
                        // Delete old file if exists
                        if ($pet->document_path) {
                            Storage::disk('public')->delete($pet->document_path);
                        }
                        // Upload new file
                        $path = $request->file("pets.$index.document")
                            ->store('pet-documents', 'public');
                        $pet->document_path = $path;
                    }
                    // If no new file uploaded, keep existing document_path (don't modify)
                    
                    $pet->save();
                }
            } else {
                // User unchecked pets, delete all
                foreach ($user->pets as $pet) {
                    if ($pet->document_path) {
                        Storage::disk('public')->delete($pet->document_path);
                    }
                }
                $user->pets()->delete();
            }
            
            // ============ CREATE APPLICATION ============
            // Store only application-specific data, reference user profile for personal data

            // Refresh user profile to get latest data
            $user->load('profile');
            
            $application = PropertyApplication::create([
                'user_id' => $user->id,
                'property_id' => $validated['property_id'],
                'agency_id' => $property->agency_id,
                'status' => 'pending',
                
                // Basic user info (from profile for quick access)
                'first_name' => $user->profile->first_name ?? $validated['first_name'],
                'last_name' => $user->profile->last_name ?? $validated['last_name'],
                'email' => $user->email,
                'phone' => ($user->profile->mobile_country_code ?? '') . ($user->profile->mobile_number ?? ''),
                'date_of_birth' => $user->profile->date_of_birth,
                'current_address' => $validated['addresses'][0]['address'] ?? '',
                
                // Calculate annual income from weekly incomes
                'annual_income' => collect($validated['incomes'])->sum('net_weekly_amount') * 52,
                
                // Application-specific fields
                'move_in_date' => $validated['move_in_date'],
                'lease_term' => $validated['lease_term'],
                'property_inspection' => $validated['property_inspection'],
                'inspection_date' => $validated['property_inspection'] === 'yes' ? $validated['inspection_date'] : null,
                'number_of_occupants' => $validated['number_of_occupants'],
                'occupants_details' => $validated['occupants_details'],
                'special_requests' => $validated['special_requests'] ?? null,
                'notes' => $validated['notes'] ?? null,
                
                // Utility Connections
                'utility_electricity' => $request->boolean('utility_electricity'),
                'utility_gas' => $request->boolean('utility_gas'),
                'utility_internet' => $request->boolean('utility_internet'),
                
                // Timestamps
                'submitted_at' => now(),
            ]);

            // ============ CREATE INSPECTION BOOKING (if applicable) ============
            if ($validated['property_inspection'] === 'yes' && $validated['inspection_date']) {
                InspectionBooking::create([
                    'property_id' => $property->id,
                    'user_id' => $user->id,
                    'inspection_date' => $validated['inspection_date'],
                    'status' => 'completed', // Since they already inspected
                    'notes' => 'Property inspected before application submission',
                ]);
            }
            
            DB::commit();
            
            // TODO: Send notification to agency
            // TODO: Send confirmation email to user
            
            return redirect()->route('user.applications.show', $application->id)
                ->with('success', 'Application submitted successfully! The property manager will review your application shortly.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Please fix the validation errors and try again.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Application submission failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Failed to submit application: ' . $e->getMessage());
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

    /**
     * Browse active properties to apply for
     */
    public function browse(Request $request)
    {
        $query = Property::with(['images', 'agency'])
            ->where('status', 'active');
        
        // Search by address/suburb/code
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('address', 'like', "%{$search}%")
                ->orWhere('suburb', 'like', "%{$search}%")
                ->orWhere('property_code', 'like', "%{$search}%");
            });
        }
        
        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            if ($request->bedrooms === '5+') {
                $query->where('bedrooms', '>=', 5);
            } else {
                $query->where('bedrooms', $request->bedrooms);
            }
        }
        
        // Filter by bathrooms
        if ($request->filled('bathrooms')) {
            if ($request->bathrooms === '3+') {
                $query->where('bathrooms', '>=', 3);
            } else {
                $query->where('bathrooms', $request->bathrooms);
            }
        }
        
        // Filter by parking
        if ($request->filled('parking')) {
            if ($request->parking === '2+') {
                $query->where('parking_spaces', '>=', 2);
            } else {
                $query->where('parking_spaces', $request->parking);
            }
        }
        
        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }
        
        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price_per_week', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price_per_week', '<=', $request->price_max);
        }
        
        // Filter by pet friendly
        if ($request->filled('pet_friendly') && $request->pet_friendly == '1') {
            $query->where('pet_friendly', true);
        }
        
        // Filter by furnished
        if ($request->filled('furnished') && $request->furnished == '1') {
            $query->where('furnished', true);
        }
        
        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price_per_week', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_per_week', 'desc');
                break;
            case 'bedrooms_high':
                $query->orderBy('bedrooms', 'desc');
                break;
            case 'bedrooms_low':
                $query->orderBy('bedrooms', 'asc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
        }
        
        $viewMode = $request->get('view', 'grid');
        $properties = $query->paginate(12)->appends($request->except('page'));
        
        // Get user's saved properties (favorited)
        $favoriteIds = SavedProperty::where('user_id', Auth::id())
                                    ->pluck('property_id')
                                    ->toArray();
        
        // Get properties user has applied to (get all application statuses)
        $appliedProperties = Application::where('user_id', Auth::id())
                                        ->get()
                                        ->groupBy('property_id')
                                        ->map(function($applications) {
                                            return $applications->pluck('status')->toArray();
                                        });
        
        // Get total count
        $totalCount = Property::where('status', 'available')->count();
        
        return view('user.applications.browse', compact(
            'properties',
            'viewMode',
            'favoriteIds',
            'appliedProperties',
            'totalCount'
        ));
    }
}