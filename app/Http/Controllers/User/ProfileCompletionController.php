<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use App\Models\UserIncome;
use App\Models\UserEmployment;
use App\Models\UserPet;
use App\Models\UserVehicle;
use App\Models\UserAddress;
use App\Models\UserReference;
use App\Models\UserIdentification;
use App\Mail\ProfileSubmittedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProfileCompletionController extends Controller
{
    /**
     * Show profile overview with all sections (card-based UI)
     */
    public function overview()
    {
        $user = Auth::user();
        $profile = $user->profile ?: new UserProfile(['user_id' => $user->id]);
        
        // Load all related data for the overview with eager loading
        $user->load([
            'incomes',
            'employments',
            'pets',
            'vehicles',
            'addresses',
            'references',
            'identifications'
        ]);
        
        // Calculate total ID points
        $totalPoints = $user->identifications->sum('points') ?? 0;
        
        // Calculate completion percentage for each section
        $completionStats = $this->calculateCompletionStats($user, $profile);
        
        // Calculate overall completion
        $overallCompletion = count(array_filter($completionStats)) / count($completionStats) * 100;
        $totalProfilePoints = ($overallCompletion / 100) * 80;
        
        return view('user.profile.overview', [
            'profile' => $profile,
            'user' => $user,
            'totalPoints' => $totalPoints,
            'completionStats' => $completionStats,
            'overallCompletion' => round($overallCompletion, 2),
            'totalProfilePoints' => round($totalProfilePoints, 2),
        ]);
    }

    /**
     * Calculate completion statistics for all sections
     */
    private function calculateCompletionStats($user, $profile)
    {
        return [
            'personal_details' => $this->isStep1Complete($profile),
            'introduction' => $this->isStep2Complete($profile),
            'income' => $this->isStep3Complete($user),
            'employment' => $this->isStep4Complete($user),
            'pets' => $this->isStep5Complete($user),
            'vehicles' => $this->isStep6Complete($user),
            'address_history' => $this->isStep7Complete($user),
            'references' => $this->isStep8Complete($user),
            'identification' => $this->isStep9Complete($user),
            'terms' => $this->isStep10Complete($profile),
        ];
    }
    
    // ==================== COMPLETION CHECK METHODS ====================
    
    private function isStep1Complete($profile)
    {
        return $profile && 
               $profile->title &&
               $profile->first_name && 
               $profile->last_name && 
               $profile->date_of_birth && 
               $profile->email &&
               $profile->mobile_country_code &&
               $profile->mobile_number;
    }
    
    private function isStep2Complete($profile)
    {
        // Introduction is optional, so always complete
        return true;
    }
    
    private function isStep3Complete($user)
    {
        return $user->incomes()->count() > 0;
    }
    
    private function isStep4Complete($user)
    {
        // Employment is optional, so always complete
        return true;
    }
    
    private function isStep5Complete($user)
    {
        // Pets are optional, so always complete
        return true;
    }
    
    private function isStep6Complete($user)
    {
        // Vehicles are optional, so always complete
        return true;
    }
    
    private function isStep7Complete($user)
    {
        return $user->addresses()->count() > 0;
    }
    
    private function isStep8Complete($user)
    {
        return $user->references()->count() >= 2;
    }
    
    private function isStep9Complete($user)
    {
        $totalPoints = $user->identifications->sum('points') ?? 0;
        return $totalPoints >= 80;
    }
    
    private function isStep10Complete($profile)
    {
        return $profile && 
               $profile->terms_accepted && 
               $profile->signature;
    }

    /**
     * Show profile completion form (redirects to overview for card-based UI)
     */
    public function index(Request $request)
    {
        return redirect()->route('user.profile.overview');
    }

    public function show(Request $request)
    {
        return redirect()->route('user.profile.overview');
    }

    /**
     * Update step - handle form submission from cards
     */
    public function updateStep(Request $request)
    {
        $user = Auth::user();
        $step = $request->input('step') ?? $request->input('current_step');
        
        try {
            DB::beginTransaction();
            
            switch ($step) {
                case 1:
                    $result = $this->saveStep1($request, $user);
                    break;
                case 2:
                    $result = $this->saveStep2($request, $user);
                    break;
                case 3:
                    $result = $this->saveStep3($request, $user);
                    break;
                case 4:
                    $result = $this->saveStep4($request, $user);
                    break;
                case 5:
                    $result = $this->saveStep5($request, $user);
                    break;
                case 6:
                    $result = $this->saveStep6($request, $user);
                    break;
                case 7:
                    $result = $this->saveStep7($request, $user);
                    break;
                case 8:
                    $result = $this->saveStep8($request, $user);
                    break;
                case 9:
                    $result = $this->saveStep9($request, $user);
                    break;
                case 10:
                    $result = $this->saveStep10($request, $user);
                    break;
                default:
                    throw new \Exception('Invalid step');
            }
            
            DB::commit();
            
            // Handle step 10 completion (redirect to view page)
            if (is_array($result) && isset($result['redirect'])) {
                return redirect($result['redirect'])
                    ->with('success', $result['message'] ?? 'Profile completed successfully!');
            }
            
            // For all other steps, redirect back to overview
            return redirect()->route('user.profile.overview')
                ->with('success', 'Section saved successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Please fix the validation errors');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Profile step save error', [
                'step' => $step,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    // ==================== STEP SAVE METHODS ====================

    private function saveStep1(Request $request, $user)
    {
        $validated = $request->validate([
            'title' => 'required|string|in:Mr,Mrs,Ms,Miss,Dr,Prof',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date|before:' . now()->subYears(18)->format('Y-m-d'),
            'email' => 'required|email|max:255',
            'mobile_country_code' => 'required|string',
            'mobile_number' => 'required|string|max:20',
            
            // Emergency Contact (optional section)
            'has_emergency_contact' => 'nullable|boolean',
            'emergency_contact_name' => 'nullable|required_if:has_emergency_contact,1|string|max:255',
            'emergency_contact_relationship' => 'nullable|required_if:has_emergency_contact,1|string|max:255',
            'emergency_contact_country_code' => 'nullable|required_if:has_emergency_contact,1|string',
            'emergency_contact_number' => 'nullable|required_if:has_emergency_contact,1|string|max:20',
            'emergency_contact_email' => 'nullable|required_if:has_emergency_contact,1|email|max:255',
            
            // Guarantor (optional section)
            'has_guarantor' => 'nullable|boolean',
            'guarantor_name' => 'nullable|required_if:has_guarantor,1|string|max:255',
            'guarantor_country_code' => 'nullable|required_if:has_guarantor,1|string',
            'guarantor_number' => 'nullable|required_if:has_guarantor,1|string|max:20',
            'guarantor_email' => 'nullable|required_if:has_guarantor,1|email|max:255',
        ]);

        $profile = $user->profile ?: new UserProfile();
        $profile->fill($validated);
        $profile->user_id = $user->id;
        $profile->save();

        // Update current step (allow non-sequential completion)
        $user->profile_current_step = max($user->profile_current_step ?? 1, 1);
        $user->save();

        return ['success' => true];
    }

    private function saveStep2(Request $request, $user)
    {
        $validated = $request->validate([
            'introduction' => 'nullable|string|max:1000',
        ]);

        $profile = $user->profile ?: new UserProfile();
        $profile->introduction = $validated['introduction'];
        $profile->user_id = $user->id;
        $profile->save();

        $user->profile_current_step = max($user->profile_current_step ?? 1, 2);
        $user->save();

        return ['success' => true];
    }

    private function saveStep3(Request $request, $user)
    {
        $validated = $request->validate([
            'incomes' => 'required|array|min:1',
            'incomes.*.source_of_income' => 'required|string|in:full_time_employment,part_time_employment,casual_employment,self_employment,centrelink,pension,investment_income,savings,other',
            'incomes.*.net_weekly_amount' => 'required|numeric|min:0|max:999999.99',
            'incomes.*.bank_statement' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        // Delete existing incomes and their files
        foreach ($user->incomes as $income) {
            if ($income->bank_statement_path) {
                Storage::disk('public')->delete($income->bank_statement_path);
            }
        }
        $user->incomes()->delete();

        // Create new income records
        foreach ($validated['incomes'] as $index => $incomeData) {
            $income = new UserIncome();
            $income->user_id = $user->id;
            $income->source_of_income = $incomeData['source_of_income'];
            $income->net_weekly_amount = $incomeData['net_weekly_amount'];
            
            // Handle file upload
            if ($request->hasFile("incomes.$index.bank_statement")) {
                $path = $request->file("incomes.$index.bank_statement")
                    ->store('bank-statements', 'public');
                $income->bank_statement_path = $path;
            }
            
            $income->save();
        }

        $user->profile_current_step = max($user->profile_current_step ?? 1, 3);
        $user->save();

        return ['success' => true];
    }

    private function saveStep4(Request $request, $user)
    {
        $hasEmployment = $request->boolean('has_employment');

        if (!$hasEmployment) {
            // Delete all employments if user says they have no employment
            foreach ($user->employments as $employment) {
                if ($employment->employment_letter_path) {
                    Storage::disk('public')->delete($employment->employment_letter_path);
                }
            }
            $user->employments()->delete();
            
            $user->profile_current_step = max($user->profile_current_step ?? 1, 4);
            $user->save();
            
            return ['success' => true];
        }

        $validated = $request->validate([
            'employments' => 'required|array|min:1',
            'employments.*.company_name' => 'required|string|max:255',
            'employments.*.address' => 'required|string|max:500',
            'employments.*.position' => 'required|string|max:255',
            'employments.*.gross_annual_salary' => 'required|numeric|min:0|max:9999999.99',
            'employments.*.manager_full_name' => 'required|string|max:255',
            'employments.*.contact_number' => 'required|string|max:20',
            'employments.*.email' => 'required|email|max:255',
            'employments.*.start_date' => 'required|date|before_or_equal:today',
            'employments.*.still_employed' => 'nullable|boolean',
            'employments.*.end_date' => 'nullable|date|before_or_equal:today|after:employments.*.start_date',
            'employments.*.employment_letter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        // Delete existing employments and their files
        foreach ($user->employments as $employment) {
            if ($employment->employment_letter_path) {
                Storage::disk('public')->delete($employment->employment_letter_path);
            }
        }
        $user->employments()->delete();

        // Create new employment records
        foreach ($validated['employments'] as $index => $employmentData) {
            $employment = new UserEmployment();
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
            
            // Handle file upload
            if ($request->hasFile("employments.$index.employment_letter")) {
                $path = $request->file("employments.$index.employment_letter")
                    ->store('employment-letters', 'public');
                $employment->employment_letter_path = $path;
            }
            
            $employment->save();
        }

        $user->profile_current_step = max($user->profile_current_step ?? 1, 4);
        $user->save();

        return ['success' => true];
    }

    private function saveStep5(Request $request, $user)
    {
        $hasPets = $request->boolean('has_pets');

        if (!$hasPets) {
            // Delete all pets if user says they have no pets
            foreach ($user->pets as $pet) {
                if ($pet->photo_path) {
                    Storage::disk('public')->delete($pet->photo_path);
                }
                if ($pet->document_path) {
                    Storage::disk('public')->delete($pet->document_path);
                }
            }
            $user->pets()->delete();
            
            $user->profile_current_step = max($user->profile_current_step ?? 1, 5);
            $user->save();
            
            return ['success' => true];
        }

        // Conditional validation for photos
        $rules = [
            'pets' => 'required|array|min:1',
            'pets.*.type' => 'required|string|in:dog,cat,bird,fish,rabbit,other',
            'pets.*.breed' => 'required|string|max:255',
            'pets.*.desexed' => 'required|boolean',
            'pets.*.size' => 'required|string|in:small,medium,large',
            'pets.*.registration_number' => 'nullable|string|max:100',
            'pets.*.document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'pets.*.existing_photo' => 'nullable|string',
        ];

        // Make photo required only if no existing photo
        foreach ($request->input('pets', []) as $index => $petData) {
            if (empty($petData['existing_photo'])) {
                $rules["pets.$index.photo"] = 'required|image|mimes:jpeg,png,jpg,gif|max:10240';
            } else {
                $rules["pets.$index.photo"] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240';
            }
        }

        $validated = $request->validate($rules);

        // Get existing pets
        $existingPets = $user->pets()->get()->keyBy(function($pet, $key) {
            return $key;
        });

        // Track which pets to keep
        $processedPetIds = [];

        // Process each pet
        foreach ($validated['pets'] as $index => $petData) {
            // Update existing pet or create new one
            $pet = $existingPets->get($index) ?: new UserPet();
            $pet->user_id = $user->id;
            $pet->type = $petData['type'];
            $pet->breed = $petData['breed'];
            $pet->desexed = $petData['desexed'];
            $pet->size = $petData['size'];
            $pet->registration_number = $petData['registration_number'] ?? null;
        
            // Handle pet photo upload
            if ($request->hasFile("pets.$index.photo")) {
                // Delete old photo if exists
                if ($pet->photo_path && Storage::disk('public')->exists($pet->photo_path)) {
                    Storage::disk('public')->delete($pet->photo_path);
                }
                // Upload new photo
                $path = $request->file("pets.$index.photo")->store('pet-photos', 'public');
                $pet->photo_path = $path;
            } elseif (isset($petData['existing_photo'])) {
                // Keep existing photo if no new file uploaded
                $pet->photo_path = $petData['existing_photo'];
            }
            
            // Handle document upload
            if ($request->hasFile("pets.$index.document")) {
                // Delete old document if exists
                if ($pet->document_path && Storage::disk('public')->exists($pet->document_path)) {
                    Storage::disk('public')->delete($pet->document_path);
                }
                $path = $request->file("pets.$index.document")->store('pet-documents', 'public');
                $pet->document_path = $path;
            }
            
            $pet->save();
            $processedPetIds[] = $pet->id;
        }

        // Delete pets that were removed (not in the submitted form)
        $petsToDelete = $user->pets()->whereNotIn('id', array_filter($processedPetIds))->get();
        foreach ($petsToDelete as $pet) {
            if ($pet->photo_path && Storage::disk('public')->exists($pet->photo_path)) {
                Storage::disk('public')->delete($pet->photo_path);
            }
            if ($pet->document_path && Storage::disk('public')->exists($pet->document_path)) {
                Storage::disk('public')->delete($pet->document_path);
            }
            $pet->delete();
        }

        $user->profile_current_step = max($user->profile_current_step ?? 1, 5);
        $user->save();

        return ['success' => true];
    }

    private function saveStep6(Request $request, $user)
    {
        $hasVehicles = $request->boolean('has_vehicles');

        if (!$hasVehicles) {
            // Delete all vehicles if user says they have no vehicles
            $user->vehicles()->delete();
            
            $user->profile_current_step = max($user->profile_current_step ?? 1, 6);
            $user->save();
            
            return ['success' => true];
        }

        $validated = $request->validate([
            'vehicles' => 'required|array|min:1',
            'vehicles.*.vehicle_type' => 'required|string|in:car,motorcycle,truck,van',
            'vehicles.*.year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'vehicles.*.make' => 'required|string|max:255',
            'vehicles.*.model' => 'required|string|max:255',
            'vehicles.*.state' => 'required|string|in:NSW,VIC,QLD,SA,WA,TAS,NT,ACT',
            'vehicles.*.registration_number' => 'required|string|max:20',
        ]);

        // Delete existing vehicles
        $user->vehicles()->delete();

        // Create new vehicle records
        foreach ($validated['vehicles'] as $vehicleData) {
            $vehicle = new UserVehicle();
            $vehicle->user_id = $user->id;
            $vehicle->vehicle_type = $vehicleData['vehicle_type'];
            $vehicle->year = $vehicleData['year'];
            $vehicle->make = $vehicleData['make'];
            $vehicle->model = $vehicleData['model'];
            $vehicle->state = $vehicleData['state'];
            $vehicle->registration_number = strtoupper($vehicleData['registration_number']);
            $vehicle->save();
        }

        $user->profile_current_step = max($user->profile_current_step ?? 1, 6);
        $user->save();

        return ['success' => true];
    }

    private function saveStep7(Request $request, $user)
    {
        $validated = $request->validate([
            'addresses' => 'required|array|min:1',
            'addresses.*.living_arrangement' => 'required|string|in:owner,renting_agent,renting_privately,with_parents,sharing,other',
            'addresses.*.address' => 'required|string|max:500',
            'addresses.*.years_lived' => 'required|integer|min:0|max:100',
            'addresses.*.months_lived' => 'required|integer|min:0|max:11',
            'addresses.*.reason_for_leaving' => 'nullable|string|max:1000',
            'addresses.*.different_postal_address' => 'nullable|boolean',
            'addresses.*.postal_code' => 'nullable|string|max:500',
            'addresses.*.is_current' => 'nullable|boolean',
        ]);

        // Delete existing addresses
        $user->addresses()->delete();

        // Create new address records
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

        $user->profile_current_step = max($user->profile_current_step ?? 1, 7);
        $user->save();

        return ['success' => true];
    }

    private function saveStep8(Request $request, $user)
    {
        $validated = $request->validate([
            'references' => 'required|array|min:2|max:10',
            'references.*.full_name' => 'required|string|max:255',
            'references.*.relationship' => 'required|string|max:255',
            'references.*.mobile_country_code' => 'required|string',
            'references.*.mobile_number' => 'required|string|max:20',
            'references.*.email' => 'required|email|max:255',
        ], [
            'references.min' => 'You must provide at least 2 references.',
        ]);

        // Delete existing references
        $user->references()->delete();

        // Create new reference records
        foreach ($validated['references'] as $referenceData) {
            $reference = new UserReference();
            $reference->user_id = $user->id;
            $reference->full_name = $referenceData['full_name'];
            $reference->relationship = $referenceData['relationship'];
            $reference->mobile_country_code = $referenceData['mobile_country_code'];
            $reference->mobile_number = $referenceData['mobile_number'];
            $reference->email = $referenceData['email'];
            $reference->save();
        }

        $user->profile_current_step = max($user->profile_current_step ?? 1, 8);
        $user->save();

        return ['success' => true];
    }

    private function saveStep9(Request $request, $user)
    {
        $validated = $request->validate([
            'identifications' => 'required|array|min:1',
            'identifications.*.identification_type' => 'required|string|in:australian_drivers_licence,passport,birth_certificate,medicare,other',
            'identifications.*.document_number' => 'nullable|string|max:100',
            'identifications.*.document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'identifications.*.expiry_date' => 'nullable|date|after:today',
        ]);

        // Delete existing identifications and their files
        foreach ($user->identifications as $identification) {
            if ($identification->document_path) {
                Storage::disk('public')->delete($identification->document_path);
            }
        }
        $user->identifications()->delete();

        $totalPoints = 0;

        // Create new identification records
        foreach ($validated['identifications'] as $index => $idData) {
            $identification = new UserIdentification();
            $identification->user_id = $user->id;
            $identification->identification_type = $idData['identification_type'];
            
            // Calculate points based on document type
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
            
            // Handle file upload
            if ($request->hasFile("identifications.$index.document")) {
                $path = $request->file("identifications.$index.document")
                    ->store('identification-documents', 'public');
                $identification->document_path = $path;
            }
            
            $identification->save();
            $totalPoints += $identification->points;
        }

        // Validate total points
        if ($totalPoints < 80) {
            throw new \Exception('You need at least 80 identification points. Current total: ' . $totalPoints . ' points.');
        }

        $user->profile_current_step = max($user->profile_current_step ?? 1, 9);
        $user->save();

        return ['success' => true];
    }

    private function saveStep10(Request $request, $user)
    {
        $validated = $request->validate([
            'terms_accepted' => 'required|accepted',
            'signature' => 'required|string|max:255|min:3',
        ], [
            'terms_accepted.accepted' => 'You must accept the terms and conditions.',
            'signature.required' => 'Your signature is required.',
            'signature.min' => 'Please enter your full name as signature.',
        ]);

        $profile = $user->profile ?: new UserProfile();
        $profile->user_id = $user->id;
        $profile->terms_accepted = true;
        $profile->signature = $validated['signature'];
        $profile->terms_accepted_at = now();
        $profile->status = 'pending'; // Submit for admin approval
        $profile->submitted_at = now();
        $profile->save();

        $user->profile_current_step = 10;
        $user->save();

        // Send admin email notification
        $this->sendAdminNotification($user, $profile);

        return [
            'success' => true,
            'message' => 'Profile submitted successfully! Your application is now pending admin approval.',
            'redirect' => route('user.profile.view')
        ];
    }

    /**
     * Send email notification to admin when profile is submitted
     */
    private function sendAdminNotification($user, $profile)
    {
        try {
            $adminEmail = config('mail.admin_email', 'admin@sorted.com');
            
            if (class_exists(ProfileSubmittedNotification::class)) {
                Mail::to($adminEmail)->send(new ProfileSubmittedNotification($user, $profile));
            }
            
            Log::info('Admin notification sent for user profile', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'admin_email' => $adminEmail
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send admin notification email', [
                'user_id' => $user->id,
                'profile_id' => $profile->id ?? null,
                'error' => $e->getMessage()
            ]);
            // Don't throw error - email failure shouldn't stop profile submission
        }
    }

    /**
     * View submitted profile (read-only)
     */
    public function view()
    {
        $user = Auth::user();
        
        $profile = $user->profile;

        if (!$profile || !$profile->submitted_at) {
            return redirect()->route('user.profile.overview')
                ->with('error', 'Please complete and submit your profile first.');
        }

        // Load all related data
        $user->load([
            'incomes',
            'employments',
            'pets',
            'vehicles',
            'addresses',
            'references',
            'identifications'
        ]);

        $totalPoints = $user->identifications->sum('points') ?? 0;

        return view('user.profile.view', compact('user', 'profile', 'totalPoints'));
    }
}