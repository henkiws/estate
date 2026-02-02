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
use App\Models\UserIncomeBankStatement;
use App\Mail\ReferenceRequestMail;
use App\Mail\ProfileSubmittedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Traits\StoresFilesWithOriginalName;

class ProfileCompletionController extends Controller
{
    use StoresFilesWithOriginalName;

    /**
     * Show profile overview with all sections (card-based UI)
     */
    public function overview()
    {
        $user = Auth::user();
        $profile = $user->profile ?: new UserProfile(['user_id' => $user->id]);

        if( $profile->status == 'pending' )
        {
            return redirect()->route('user.profile.view');
        }

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
                case 0:
                    $result = $this->saveStep0($request, $user);
                    $nextSection = 'personal-details-card';
                    break;
                case 1:
                    $result = $this->saveStep1($request, $user);
                    $nextSection = 'introduction-card';
                    break;
                case 2:
                    $result = $this->saveStep2($request, $user);
                    $nextSection = 'income-card';
                    break;
                case 3:
                    $result = $this->saveStep3($request, $user);
                    $nextSection = 'employment-card';
                    break;
                case 4:
                    $result = $this->saveStep4($request, $user);
                    $nextSection = 'pets-card';
                    break;
                case 5:
                    $result = $this->saveStep5($request, $user);
                    $nextSection = 'vehicles-card';
                    break;
                case 6:
                    $result = $this->saveStep6($request, $user);
                    $nextSection = 'address-history-card';
                    break;
                case 7:
                    $result = $this->saveStep7($request, $user);
                    $nextSection = 'references-card';
                    break;
                case 8:
                    $result = $this->saveStep8($request, $user);
                    $nextSection = 'identification-card';
                    break;
                case 9:
                    $result = $this->saveStep9($request, $user);
                    $nextSection = 'terms-card';
                    break;
                case 10:
                    $result = $this->saveStep10($request, $user);
                    $nextSection = null; // No next section for final step
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
            
            // For all other steps, redirect back with next section to scroll to
            return redirect()->route('user.profile.overview')
                ->with('success', 'Section saved successfully!')
                ->with('scroll_to', $nextSection);
            
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

    /**
     * Save Step 3: Income Information with ORIGINAL FILENAMES
     */
    private function saveStep3(Request $request, $user)
    {
        $validated = $request->validate([
            'incomes' => 'required|array|min:1',
            'incomes.*.id' => 'nullable|exists:user_incomes,id',
            'incomes.*.source_of_income' => 'required|string|in:full_time_employment,part_time_employment,casual_employment,self_employed,centrelink,pension,investment,savings,other',
            'incomes.*.net_weekly_amount' => 'required|numeric|min:0|max:999999.99',
            'incomes.*.bank_statements' => 'nullable|array',
            'incomes.*.bank_statements.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10240',
            'incomes.*.delete_statements' => 'nullable|array',
            'incomes.*.delete_statements.*' => 'nullable|exists:user_income_bank_statements,id',
        ]);

        // Track which income IDs are being processed
        $processedIncomeIds = [];

        // Process each income entry
        foreach ($validated['incomes'] as $index => $incomeData) {
            // Update existing or create new income
            if (!empty($incomeData['id'])) {
                $income = UserIncome::find($incomeData['id']);
                if (!$income || $income->user_id !== $user->id) {
                    continue;
                }
            } else {
                $income = new UserIncome();
                $income->user_id = $user->id;
            }

            $income->source_of_income = $incomeData['source_of_income'];
            $income->net_weekly_amount = $incomeData['net_weekly_amount'];
            $income->save();

            $processedIncomeIds[] = $income->id;

            // Handle deletion of existing bank statements
            if (!empty($incomeData['delete_statements'])) {
                foreach ($incomeData['delete_statements'] as $statementId) {
                    if (!empty($statementId)) {
                        $statement = UserIncomeBankStatement::where('id', $statementId)
                            ->where('user_income_id', $income->id)
                            ->first();
                        
                        if ($statement) {
                            if ($statement->file_path && Storage::disk('public')->exists($statement->file_path)) {
                                Storage::disk('public')->delete($statement->file_path);
                            }
                            $statement->delete();
                        }
                    }
                }
            }

            // Handle new bank statement uploads with ORIGINAL FILENAMES
            if ($request->hasFile("incomes.$index.bank_statements")) {
                $files = $request->file("incomes.$index.bank_statements");
                
                foreach ($files as $file) {
                    // Store with original filename
                    $path = $this->storeFileWithOriginalName($file, 'bank-statements');
                    
                    // Create bank statement record
                    $bankStatement = new UserIncomeBankStatement();
                    $bankStatement->user_income_id = $income->id;
                    $bankStatement->file_path = $path;
                    $bankStatement->original_filename = $file->getClientOriginalName();
                    $bankStatement->file_size = $file->getSize();
                    $bankStatement->mime_type = $file->getMimeType();
                    $bankStatement->save();
                }
            }
        }

        // Delete income entries that were removed from the form
        $incomesToDelete = $user->incomes()
            ->whereNotIn('id', array_filter($processedIncomeIds))
            ->get();
        
        foreach ($incomesToDelete as $income) {
            $statements = UserIncomeBankStatement::where('user_income_id', $income->id)->get();
            foreach ($statements as $statement) {
                if ($statement->file_path && Storage::disk('public')->exists($statement->file_path)) {
                    Storage::disk('public')->delete($statement->file_path);
                }
                $statement->delete();
            }
            $income->delete();
        }

        $user->profile_current_step = max($user->profile_current_step ?? 1, 3);
        $user->save();

        return ['success' => true];
    }

    /**
     * Save Step 4: Employment Information - FIXED EMAIL SENDING LOGIC
     * Only sends email when:
     * 1. New employment added
     * 2. Email address changed
     * 3. Key details changed (company, position, manager name)
     */
    private function saveStep4(Request $request, $user)
    {
        $hasEmployment = $request->boolean('has_employment');

        if (!$hasEmployment) {
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
            'employments.*.id' => 'nullable|exists:user_employments,id',
            'employments.*.company_name' => 'required|string|max:255',
            'employments.*.position' => 'required|string|max:255',
            'employments.*.address' => 'required|string|max:500',
            'employments.*.manager_full_name' => 'required|string|max:255',
            'employments.*.contact_country_code' => 'required|string',
            'employments.*.contact_number' => 'required|string|max:20',
            'employments.*.email' => 'required|email|max:255',
            'employments.*.start_date' => 'required|date|before_or_equal:today',
            'employments.*.still_employed' => 'nullable|boolean',
            'employments.*.end_date' => 'nullable|date|before_or_equal:today|after:employments.*.start_date',
            'employments.*.employment_letter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'employments.*.existing_letter' => 'nullable|string',
        ]);

        // Custom validation for end_date when not still employed
        foreach ($validated['employments'] as $index => $employmentData) {
            $stillEmployed = $employmentData['still_employed'] ?? false;
            
            if (!$stillEmployed && empty($employmentData['end_date'])) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(["employments.{$index}.end_date" => "End date is required when not currently employed"]);
            }
            
            if (!empty($employmentData['end_date']) && !empty($employmentData['start_date'])) {
                if ($employmentData['end_date'] < $employmentData['start_date']) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(["employments.{$index}.end_date" => "End date must be after start date"]);
                }
            }
        }

        $existingEmployments = $user->employments()->get()->keyBy('id');
        $processedEmploymentIds = [];
        $employmentsNeedingEmail = [];

        foreach ($validated['employments'] as $index => $employmentData) {
            $employmentId = $employmentData['id'] ?? null;
            $employment = $employmentId ? $existingEmployments->get($employmentId) : null;
            
            $isNewEmployment = !$employment;
            
            // ✅ FIXED: Track what actually changed
            $emailChanged = false;
            $detailsChanged = false;
            
            if (!$isNewEmployment) {
                // Check if email changed
                if ($employment->email !== $employmentData['email']) {
                    $emailChanged = true;
                }
                
                // Check if critical details changed (company, position, manager name)
                if ($employment->company_name !== $employmentData['company_name'] ||
                    $employment->position !== $employmentData['position'] ||
                    $employment->manager_full_name !== $employmentData['manager_full_name']) {
                    $detailsChanged = true;
                }
            }
            
            $employment = $employment ?: new UserEmployment();
            
            $employment->user_id = $user->id;
            $employment->company_name = $employmentData['company_name'];
            $employment->address = $employmentData['address'];
            $employment->position = $employmentData['position'];
            $employment->manager_full_name = $employmentData['manager_full_name'];
            $employment->contact_country_code = $employmentData['contact_country_code'];
            $employment->contact_number = $employmentData['contact_number'];
            $employment->email = $employmentData['email'];
            $employment->start_date = $employmentData['start_date'];
            $employment->still_employed = $employmentData['still_employed'] ?? false;
            $employment->end_date = $employmentData['end_date'] ?? null;
            $employment->gross_annual_salary = $employmentData['gross_annual_salary'] ?? null;
            
            // Handle file upload with ORIGINAL FILENAME
            if ($request->hasFile("employments.$index.employment_letter")) {
                if ($employment->employment_letter_path && Storage::disk('public')->exists($employment->employment_letter_path)) {
                    Storage::disk('public')->delete($employment->employment_letter_path);
                }
                $path = $this->storeFileWithOriginalName(
                    $request->file("employments.$index.employment_letter"),
                    'employment-letters'
                );
                $employment->employment_letter_path = $path;
            } elseif (isset($employmentData['existing_letter'])) {
                $employment->employment_letter_path = $employmentData['existing_letter'];
            }
            
            // ✅ FIXED: Only generate new token and send email when needed
            $shouldSendEmail = false;
            
            if ($isNewEmployment) {
                // New employment - always send email
                $shouldSendEmail = true;
                $employment->reference_token = \Str::random(64);
                $employment->reference_status = 'pending';
                $employment->reference_email_sent_at = null;
                $employment->reference_verified_at = null;
            } elseif ($emailChanged || $detailsChanged) {
                // Existing employment with changes - only send if not verified
                if ($employment->reference_status !== 'verified') {
                    $shouldSendEmail = true;
                    $employment->reference_token = \Str::random(64);
                    $employment->reference_status = 'pending';
                    $employment->reference_email_sent_at = null;
                    $employment->reference_verified_at = null;
                }
            }
            // else: No changes - don't send email
            
            $employment->save();
            $processedEmploymentIds[] = $employment->id;
            
            if ($shouldSendEmail) {
                $employmentsNeedingEmail[] = $employment;
            }
        }

        // Delete employments that were removed
        $employmentsToDelete = $user->employments()->whereNotIn('id', array_filter($processedEmploymentIds))->get();
        foreach ($employmentsToDelete as $employment) {
            if ($employment->employment_letter_path && Storage::disk('public')->exists($employment->employment_letter_path)) {
                Storage::disk('public')->delete($employment->employment_letter_path);
            }
            $employment->delete();
        }

        // ✅ Send employment reference emails ONLY for employments that need it
        $emailsSent = 0;
        foreach ($employmentsNeedingEmail as $employment) {
            try {
                \Mail::to($employment->email)->send(new \App\Mail\EmploymentReferenceRequest($employment));
                $employment->reference_email_sent_at = now();
                $employment->save();
                $emailsSent++;
            } catch (\Exception $e) {
                Log::error('Failed to send employment reference email', [
                    'employment_id' => $employment->id,
                    'email' => $employment->email,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $user->profile_current_step = max($user->profile_current_step ?? 1, 4);
        $user->save();

        // ✅ Provide feedback about emails sent
        if ($emailsSent > 0) {
            $message = $emailsSent === 1 
                ? 'Employment saved! Reference email sent to 1 employer.' 
                : "Employment saved! Reference emails sent to {$emailsSent} employers.";
        } else {
            $message = 'Employment information saved successfully!';
        }

        return [
            'success' => true,
            'message' => $message
        ];
    }

    /**
     * Save Step 5: Pets Information with ORIGINAL FILENAMES
     */
    private function saveStep5(Request $request, $user)
    {
        $hasPets = $request->boolean('has_pets');

        if (!$hasPets) {
            foreach ($user->pets as $pet) {
                if ($pet->photo_paths) {
                    foreach ($pet->photo_paths as $photoPath) {
                        if (Storage::disk('public')->exists($photoPath)) {
                            Storage::disk('public')->delete($photoPath);
                        }
                    }
                }
                if ($pet->document_paths) {
                    foreach ($pet->document_paths as $docPath) {
                        if (Storage::disk('public')->exists($docPath)) {
                            Storage::disk('public')->delete($docPath);
                        }
                    }
                }
            }
            $user->pets()->delete();
            
            $user->profile_current_step = max($user->profile_current_step ?? 1, 5);
            $user->save();
            
            return ['success' => true];
        }

        $rules = [
            'pets' => 'required|array|min:1',
            'pets.*.type' => 'required|string|in:dog,cat,bird,fish,rabbit,other',
            'pets.*.breed' => 'required|string|max:255',
            'pets.*.desexed' => 'required|boolean',
            'pets.*.size' => 'required|string|in:small,medium,large',
            'pets.*.registration_number' => 'nullable|string|max:100',
            'pets.*.photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'pets.*.documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'pets.*.existing_photos' => 'nullable|array',
            'pets.*.existing_documents' => 'nullable|array',
        ];

        foreach ($request->input('pets', []) as $index => $petData) {
            $hasExistingPhotos = !empty($petData['existing_photos']);
            $hasNewPhotos = $request->hasFile("pets.$index.photos");
            
            if (!$hasExistingPhotos && !$hasNewPhotos) {
                $rules["pets.$index.photos"] = 'required|array|min:1';
            }
        }

        $validated = $request->validate($rules);

        $existingPets = $user->pets()->get()->keyBy(function($pet, $key) {
            return $key;
        });

        $processedPetIds = [];

        foreach ($validated['pets'] as $index => $petData) {
            $pet = $existingPets->get($index) ?: new UserPet();
            $pet->user_id = $user->id;
            $pet->type = $petData['type'];
            $pet->breed = $petData['breed'];
            $pet->desexed = $petData['desexed'];
            $pet->size = $petData['size'];
            $pet->registration_number = $petData['registration_number'] ?? null;
        
            // ========== HANDLE MULTIPLE PHOTO UPLOADS WITH ORIGINAL FILENAMES ==========
            $photoPaths = [];
            
            if (isset($petData['existing_photos']) && is_array($petData['existing_photos'])) {
                $photoPaths = array_merge($photoPaths, $petData['existing_photos']);
            }
            
            // Upload new photos with original filenames
            if ($request->hasFile("pets.$index.photos")) {
                $newPaths = $this->storeFilesWithOriginalNames(
                    $request->file("pets.$index.photos"),
                    'pet-photos'
                );
                $photoPaths = array_merge($photoPaths, $newPaths);
            }
            
            if ($pet->photo_paths) {
                $oldPhotos = $pet->photo_paths;
                foreach ($oldPhotos as $oldPath) {
                    if (!in_array($oldPath, $photoPaths) && Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            }
            
            $pet->photo_paths = $photoPaths;
            
            // ========== HANDLE MULTIPLE DOCUMENT UPLOADS WITH ORIGINAL FILENAMES ==========
            $documentPaths = [];
            
            if (isset($petData['existing_documents']) && is_array($petData['existing_documents'])) {
                $documentPaths = array_merge($documentPaths, $petData['existing_documents']);
            }
            
            // Upload new documents with original filenames
            if ($request->hasFile("pets.$index.documents")) {
                $newPaths = $this->storeFilesWithOriginalNames(
                    $request->file("pets.$index.documents"),
                    'pet-documents'
                );
                $documentPaths = array_merge($documentPaths, $newPaths);
            }
            
            if ($pet->document_paths) {
                $oldDocs = $pet->document_paths;
                foreach ($oldDocs as $oldPath) {
                    if (!in_array($oldPath, $documentPaths) && Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            }
            
            $pet->document_paths = $documentPaths;
            
            $pet->save();
            $processedPetIds[] = $pet->id;
        }

        $petsToDelete = $user->pets()->whereNotIn('id', array_filter($processedPetIds))->get();
        foreach ($petsToDelete as $pet) {
            if ($pet->photo_paths) {
                foreach ($pet->photo_paths as $photoPath) {
                    if (Storage::disk('public')->exists($photoPath)) {
                        Storage::disk('public')->delete($photoPath);
                    }
                }
            }
            if ($pet->document_paths) {
                foreach ($pet->document_paths as $docPath) {
                    if (Storage::disk('public')->exists($docPath)) {
                        Storage::disk('public')->delete($docPath);
                    }
                }
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

    /**
     * FIXED: Save Step 7 with Proper Email Change Detection
     * 
     * The issue: Email change detection was checking the OLD address object's email
     * BEFORE we set the new values, so it was comparing the wrong values
     */
    private function saveStep7(Request $request, $user)
    {
        $validated = $request->validate([
            'addresses' => 'required|array|min:1',
            'addresses.*.id' => 'nullable|exists:user_addresses,id',
            'addresses.*.owned_property' => 'required|boolean',
            'addresses.*.living_arrangement' => 'required_if:addresses.*.owned_property,0|nullable|string|in:property_manager,private_landlord,parents,other',
            'addresses.*.address' => 'required|string|max:500',
            'addresses.*.years_lived' => 'required|integer|min:0|max:100',
            'addresses.*.months_lived' => 'required|integer|min:0|max:11',
            'addresses.*.reason_for_leaving' => 'nullable|string|max:1000',
            'addresses.*.different_postal_address' => 'nullable|boolean',
            'addresses.*.postal_code' => 'nullable|string|max:500',
            'addresses.*.is_current' => 'nullable|boolean',
            'addresses.*.reference_full_name' => 'required_if:addresses.*.owned_property,0|nullable|string|max:255',
            'addresses.*.reference_email' => 'required_if:addresses.*.owned_property,0|nullable|email|max:255',
            'addresses.*.reference_country_code' => 'required_if:addresses.*.owned_property,0|nullable|string',
            'addresses.*.reference_phone' => 'required_if:addresses.*.owned_property,0|nullable|string|max:20',
        ]);

        $existingAddresses = $user->addresses()->get()->keyBy('id');
        $processedAddressIds = [];
        $addressesNeedingEmail = [];

        foreach ($validated['addresses'] as $addressData) {
            $addressId = $addressData['id'] ?? null;
            $oldAddress = $addressId ? $existingAddresses->get($addressId) : null;
            
            $isNewAddress = !$oldAddress;
            
            // ✅ FIX: Store old values BEFORE creating/updating address object
            $oldEmail = $oldAddress->reference_email ?? null;
            $oldName = $oldAddress->reference_full_name ?? null;
            $oldStatus = $oldAddress->reference_status ?? null;
            $wasOwned = $oldAddress ? $oldAddress->owned_property : null;
            
            // Get new values from form
            $newEmail = $addressData['reference_email'] ?? null;
            $newName = $addressData['reference_full_name'] ?? null;
            $isOwned = filter_var($addressData['owned_property'] ?? true, FILTER_VALIDATE_BOOLEAN);
            
            // ✅ FIX: Determine changes using old vs new comparison
            $emailChanged = false;
            $detailsChanged = false;
            
            if (!$isNewAddress && !$isOwned) {
                // Check if reference email changed
                if ($oldEmail !== $newEmail) {
                    $emailChanged = true;
                    Log::info('Email changed', [
                        'old' => $oldEmail,
                        'new' => $newEmail
                    ]);
                }
                
                // Check if reference details changed
                if ($oldName !== $newName) {
                    $detailsChanged = true;
                    Log::info('Reference name changed', [
                        'old' => $oldName,
                        'new' => $newName
                    ]);
                }
            }
            
            // Create or update address
            $address = $oldAddress ?: new UserAddress();
            $address->user_id = $user->id;
            $address->owned_property = $isOwned;
            
            if ($isOwned) {
                // Owned - clear reference fields
                $address->living_arrangement = 'owner';
                $address->reference_full_name = null;
                $address->reference_email = null;
                $address->reference_country_code = null;
                $address->reference_phone = null;
                $address->reference_token = null;
                $address->reference_status = null;
                $address->reference_email_sent_at = null;
                $address->reference_verified_at = null;
            } else {
                // Not owned - handle reference
                $address->living_arrangement = $addressData['living_arrangement'];
                $address->reference_full_name = $newName;
                $address->reference_email = $newEmail;
                $address->reference_country_code = $addressData['reference_country_code'] ?? null;
                $address->reference_phone = $addressData['reference_phone'] ?? null;
                
                // ✅ FIX: Determine if we should send email
                $shouldSendEmail = false;
                
                if ($isNewAddress && $newEmail) {
                    // New address with reference email
                    $shouldSendEmail = true;
                    Log::info('New address - will send email', ['email' => $newEmail]);
                    
                } elseif (($emailChanged || $detailsChanged) && $newEmail) {
                    // Existing address with changes
                    if ($oldStatus !== 'verified') {
                        $shouldSendEmail = true;
                        Log::info('Changes detected, not verified - will send email', [
                            'email_changed' => $emailChanged,
                            'details_changed' => $detailsChanged,
                            'old_status' => $oldStatus,
                            'email' => $newEmail
                        ]);
                    } else {
                        Log::info('Changes detected but verified - NOT sending', [
                            'old_status' => $oldStatus
                        ]);
                    }
                }
                
                if ($shouldSendEmail) {
                    // Generate new token and set to pending
                    $address->reference_token = \Str::random(64);
                    $address->reference_status = 'pending';
                    $address->reference_email_sent_at = null;
                    $address->reference_verified_at = null;
                    
                    $addressesNeedingEmail[] = $address;
                    
                    Log::info('Added to email queue', [
                        'email' => $newEmail,
                        'is_new' => $isNewAddress,
                        'email_changed' => $emailChanged,
                        'details_changed' => $detailsChanged
                    ]);
                }
            }
            
            // Save common fields
            $address->address = $addressData['address'];
            $address->years_lived = $addressData['years_lived'];
            $address->months_lived = $addressData['months_lived'];
            $address->reason_for_leaving = $addressData['reason_for_leaving'] ?? null;
            $address->different_postal_address = $addressData['different_postal_address'] ?? false;
            $address->postal_code = $addressData['postal_code'] ?? null;
            $address->is_current = $addressData['is_current'] ?? false;
            $address->save();
            
            $processedAddressIds[] = $address->id;
        }

        // Delete removed addresses
        $addressesToDelete = $user->addresses()->whereNotIn('id', array_filter($processedAddressIds))->get();
        foreach ($addressesToDelete as $address) {
            $address->delete();
        }

        // ✅ DEBUG: Log what's about to be sent
        Log::info('Final email queue', [
            'count' => count($addressesNeedingEmail),
            'emails' => collect($addressesNeedingEmail)->pluck('reference_email')->toArray()
        ]);

        // Send address reference emails
        $emailsSent = 0;
        foreach ($addressesNeedingEmail as $address) {
            try {
                \Mail::to($address->reference_email)->send(new \App\Mail\AddressReferenceRequest($address));
                $address->reference_email_sent_at = now();
                $address->save();
                $emailsSent++;
                
                Log::info('Email sent successfully', [
                    'email' => $address->reference_email,
                    'address_id' => $address->id
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send address reference email', [
                    'address_id' => $address->id,
                    'email' => $address->reference_email,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $user->profile_current_step = max($user->profile_current_step ?? 1, 7);
        $user->save();

        if ($emailsSent > 0) {
            $message = $emailsSent === 1 
                ? 'Address saved! Reference email sent to 1 landlord/property manager.' 
                : "Address saved! Reference emails sent to {$emailsSent} landlords/property managers.";
        } else {
            $message = 'Address history saved successfully!';
        }

        return [
            'success' => true,
            'message' => $message
        ];
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

    /**
     * Save Step 9: Identification Documents with ORIGINAL FILENAMES
     */
    private function saveStep9(Request $request, $user)
    {
        $rules = [
            'identifications' => 'required|array|min:1',
            'identifications.*.identification_type' => 'required|string|in:australian_drivers_licence,passport,birth_certificate,medicare,other',
            'identifications.*.document_number' => 'nullable|string|max:255',
            'identifications.*.expiry_date' => 'nullable|date|after:today',
            'identifications.*.documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'identifications.*.existing_documents' => 'nullable|array',
        ];

        foreach ($request->input('identifications', []) as $index => $idData) {
            $hasExistingDocuments = !empty($idData['existing_documents']);
            $hasNewDocuments = $request->hasFile("identifications.$index.documents");
            
            if (!$hasExistingDocuments && !$hasNewDocuments) {
                $rules["identifications.$index.documents"] = 'required|array|min:1';
            }
        }

        $validated = $request->validate($rules);

        $existingIdentifications = $user->identifications()->get()->keyBy(function($id, $key) {
            return $key;
        });

        $processedIdIds = [];
        $totalPoints = 0;

        foreach ($validated['identifications'] as $index => $idData) {
            $identification = $existingIdentifications->get($index) ?: new UserIdentification();
            $identification->user_id = $user->id;
            $identification->identification_type = $idData['identification_type'];
            $identification->document_number = $idData['document_number'] ?? null;
            $identification->expiry_date = $idData['expiry_date'] ?? null;
            
            $identification->points = match($idData['identification_type']) {
                'australian_drivers_licence' => 40,
                'passport' => 70,
                'birth_certificate' => 70,
                'medicare' => 25,
                default => 0,
            };
            
            $totalPoints += $identification->points;
        
            // ========== HANDLE MULTIPLE DOCUMENT UPLOADS WITH ORIGINAL FILENAMES ==========
            $documentPaths = [];
            
            if (isset($idData['existing_documents']) && is_array($idData['existing_documents'])) {
                $documentPaths = array_merge($documentPaths, $idData['existing_documents']);
            }
            
            // Upload new documents with original filenames
            if ($request->hasFile("identifications.$index.documents")) {
                $newPaths = $this->storeFilesWithOriginalNames(
                    $request->file("identifications.$index.documents"),
                    'identification-documents'
                );
                $documentPaths = array_merge($documentPaths, $newPaths);
            }
            
            if ($identification->document_paths) {
                $oldDocs = $identification->document_paths;
                foreach ($oldDocs as $oldPath) {
                    if (!in_array($oldPath, $documentPaths) && Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            }
            
            $identification->document_paths = $documentPaths;
            
            $identification->save();
            $processedIdIds[] = $identification->id;
        }

        $identificationsToDelete = $user->identifications()->whereNotIn('id', array_filter($processedIdIds))->get();
        foreach ($identificationsToDelete as $identification) {
            if ($identification->document_paths) {
                foreach ($identification->document_paths as $docPath) {
                    if (Storage::disk('public')->exists($docPath)) {
                        Storage::disk('public')->delete($docPath);
                    }
                }
            }
            $identification->delete();
        }

        if ($totalPoints < 80) {
            return [
                'success' => false,
                'message' => "You need at least 80 points. You currently have {$totalPoints} points. Please add more identification documents.",
            ];
        }

        $user->profile_current_step = max($user->profile_current_step ?? 1, 9);
        $user->save();

        return [
            'success' => true,
            'message' => "Identification documents saved successfully. Total points: {$totalPoints}",
        ];
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

        // Send reference request emails
        $this->sendReferenceRequests($user);

        // Send reference request emails to address references
        $this->sendAddressReferenceRequests($user);

        return [
            'success' => true,
            'message' => 'Profile submitted successfully! Your application is now pending admin approval. Reference requests have been sent.',
            'redirect' => route('user.profile.view')
        ];
    }

    /**
     * Send reference request emails to all user references
     */
    private function sendReferenceRequests($user)
    {
        $references = $user->references()->get();

        if ($references->isEmpty()) {
            Log::info("No references found for user {$user->id}");
            return;
        }

        foreach ($references as $reference) {
            try {
                // Reset reference status for resubmission
                $reference->update([
                    'reference_status' => 'pending',
                    'reference_submitted_at' => null,
                    'reference_response' => null,
                ]);

                // Send email
                Mail::to($reference->email)->send(new ReferenceRequestMail($user, $reference));

                Log::info("Reference request email sent to {$reference->email} for user {$user->id}");
            } catch (\Exception $e) {
                Log::error("Failed to send reference request email to {$reference->email}: " . $e->getMessage());
                // Continue sending to other references even if one fails
            }
        }
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
     * Send reference request emails to address references
     */
    private function sendAddressReferenceRequests($user)
    {
        // Get all addresses that need references (owned_property = 0)
        $addressesNeedingReferences = $user->addresses()
            ->where('owned_property', false)
            ->whereNotNull('reference_email')
            ->get();

        if ($addressesNeedingReferences->isEmpty()) {
            \Log::info('No address references to send', ['user_id' => $user->id]);
            return;
        }

        foreach ($addressesNeedingReferences as $address) {
            // Skip if email was already sent
            if ($address->reference_email_sent_at) {
                \Log::info('Address reference email already sent, skipping', [
                    'address_id' => $address->id,
                    'reference_email' => $address->reference_email,
                    'sent_at' => $address->reference_email_sent_at,
                ]);
                continue;
            }

            // Generate token if not exists
            if (!$address->reference_token) {
                $address->reference_token = \Str::random(64);
                $address->save();
            }

            try {
                \Mail::to($address->reference_email)->send(
                    new \App\Mail\AddressReferenceRequest($address, $user, null)
                );
                
                // Update the sent timestamp
                $address->reference_email_sent_at = now();
                $address->save();
                
                \Log::info('Address reference email sent (Profile Submission)', [
                    'address_id' => $address->id,
                    'reference_email' => $address->reference_email,
                    'reference_full_name' => $address->reference_full_name,
                    'user_id' => $user->id,
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to send address reference email (Profile Submission)', [
                    'address_id' => $address->id,
                    'reference_email' => $address->reference_email,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                // Don't fail the whole submission if email fails
            }
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