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

class ProfileCompletionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile ?: new UserProfile(['user_id' => $user->id]);
        
        // Check if profile is already approved
        if ($profile->exists && $profile->isComplete()) {
            return redirect()->route('user.dashboard')
                ->with('info', 'Your profile is already complete and approved.');
        }

        $currentStep = $user->profile_current_step ?? 1;
        
        return view('user.profile.complete', [
            'currentStep' => $currentStep,
            'profile' => $profile,
            'user' => $user,
        ]);
    }

    public function updateStep(Request $request)
    {
        $user = Auth::user();
        $step = $request->input('step');
        
        switch ($step) {
            case 1:
                return $this->saveStep1($request, $user);
            case 2:
                return $this->saveStep2($request, $user);
            case 3:
                return $this->saveStep3($request, $user);
            case 4:
                return $this->saveStep4($request, $user);
            case 5:
                return $this->saveStep5($request, $user);
            case 6:
                return $this->saveStep6($request, $user);
            case 7:
                return $this->saveStep7($request, $user);
            case 8:
                return $this->saveStep8($request, $user);
            case 9:
                return $this->saveStep9($request, $user);
            case 10:
                return $this->saveStep10($request, $user);
            default:
                return redirect()->back()->with('error', 'Invalid step');
        }
    }

    private function saveStep1(Request $request, $user)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'email' => 'required|email',
            'mobile_country_code' => 'required|string',
            'mobile_number' => 'required|string',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_relationship' => 'required|string|max:255',
            'emergency_contact_country_code' => 'required|string',
            'emergency_contact_number' => 'required|string',
            'emergency_contact_email' => 'required|email',
            'has_guarantor' => 'boolean',
            'guarantor_name' => 'required_if:has_guarantor,true|nullable|string|max:255',
            'guarantor_country_code' => 'required_if:has_guarantor,true|nullable|string',
            'guarantor_number' => 'required_if:has_guarantor,true|nullable|string',
            'guarantor_email' => 'required_if:has_guarantor,true|nullable|email',
        ]);

        $profile = $user->profile ?: new UserProfile();
        $profile->fill($validated);
        $profile->user_id = $user->id;
        $profile->save();

        $user->profile_current_step = 2;
        $user->save();

        return response()->json(['success' => true, 'next_step' => 2]);
    }

    private function saveStep2(Request $request, $user)
    {
        $validated = $request->validate([
            'introduction' => 'nullable|string|max:1000',
        ]);

        $profile = $user->profile;
        $profile->update($validated);

        $user->profile_current_step = 3;
        $user->save();

        return response()->json(['success' => true, 'next_step' => 3]);
    }

    private function saveStep3(Request $request, $user)
    {
        $validated = $request->validate([
            'incomes' => 'required|array|min:1',
            'incomes.*.source_of_income' => 'required|string|max:255',
            'incomes.*.net_weekly_amount' => 'required|numeric|min:0',
            'incomes.*.bank_statement' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        // Delete existing incomes
        $user->incomes()->delete();

        foreach ($validated['incomes'] as $index => $incomeData) {
            $income = new UserIncome($incomeData);
            $income->user_id = $user->id;
            
            if ($request->hasFile("incomes.$index.bank_statement")) {
                $path = $request->file("incomes.$index.bank_statement")
                    ->store('bank-statements', 'public');
                $income->bank_statement_path = $path;
            }
            
            $income->save();
        }

        $user->profile_current_step = 4;
        $user->save();

        return response()->json(['success' => true, 'next_step' => 4]);
    }

    private function saveStep4(Request $request, $user)
    {
        $hasEmployment = $request->input('has_employment', false);

        if (!$hasEmployment) {
            $user->profile_current_step = 5;
            $user->save();
            return response()->json(['success' => true, 'next_step' => 5]);
        }

        $validated = $request->validate([
            'employments' => 'required|array|min:1',
            'employments.*.company_name' => 'required|string|max:255',
            'employments.*.address' => 'required|string',
            'employments.*.position' => 'required|string|max:255',
            'employments.*.gross_annual_salary' => 'required|numeric|min:0',
            'employments.*.manager_full_name' => 'required|string|max:255',
            'employments.*.contact_number' => 'required|string',
            'employments.*.email' => 'required|email',
            'employments.*.employment_letter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'employments.*.start_date' => 'required|date',
            'employments.*.still_employed' => 'boolean',
            'employments.*.end_date' => 'nullable|date|required_if:employments.*.still_employed,false',
        ]);

        // Delete existing employments
        $user->employments()->delete();

        foreach ($validated['employments'] as $index => $employmentData) {
            $employment = new UserEmployment($employmentData);
            $employment->user_id = $user->id;
            
            if ($request->hasFile("employments.$index.employment_letter")) {
                $path = $request->file("employments.$index.employment_letter")
                    ->store('employment-letters', 'public');
                $employment->employment_letter_path = $path;
            }
            
            $employment->save();
        }

        $user->profile_current_step = 5;
        $user->save();

        return response()->json(['success' => true, 'next_step' => 5]);
    }

    private function saveStep5(Request $request, $user)
    {
        $hasPets = $request->input('has_pets', false);

        if (!$hasPets) {
            $user->profile_current_step = 6;
            $user->save();
            return response()->json(['success' => true, 'next_step' => 6]);
        }

        $validated = $request->validate([
            'pets' => 'required|array|min:1',
            'pets.*.type' => 'required|in:dog,cat,other',
            'pets.*.breed' => 'required|string|max:255',
            'pets.*.desexed' => 'required|in:yes,no',
            'pets.*.size' => 'required|in:small,medium,large',
            'pets.*.registration_number' => 'nullable|string|max:255',
            'pets.*.document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        // Delete existing pets
        $user->pets()->delete();

        foreach ($validated['pets'] as $index => $petData) {
            $pet = new UserPet($petData);
            $pet->user_id = $user->id;
            
            if ($request->hasFile("pets.$index.document")) {
                $path = $request->file("pets.$index.document")
                    ->store('pet-documents', 'public');
                $pet->document_path = $path;
            }
            
            $pet->save();
        }

        $user->profile_current_step = 6;
        $user->save();

        return response()->json(['success' => true, 'next_step' => 6]);
    }

    private function saveStep6(Request $request, $user)
    {
        $hasVehicles = $request->input('has_vehicles', false);

        if (!$hasVehicles) {
            $user->profile_current_step = 7;
            $user->save();
            return response()->json(['success' => true, 'next_step' => 7]);
        }

        $validated = $request->validate([
            'vehicles' => 'required|array|min:1',
            'vehicles.*.vehicle_type' => 'required|in:car,motorcycle',
            'vehicles.*.year' => 'required|string|max:4',
            'vehicles.*.make' => 'required|string|max:255',
            'vehicles.*.model' => 'required|string|max:255',
            'vehicles.*.state' => 'required|string|max:255',
            'vehicles.*.registration_number' => 'required|string|max:255',
        ]);

        // Delete existing vehicles
        $user->vehicles()->delete();

        foreach ($validated['vehicles'] as $vehicleData) {
            $vehicle = new UserVehicle($vehicleData);
            $vehicle->user_id = $user->id;
            $vehicle->save();
        }

        $user->profile_current_step = 7;
        $user->save();

        return response()->json(['success' => true, 'next_step' => 7]);
    }

    private function saveStep7(Request $request, $user)
    {
        $validated = $request->validate([
            'addresses' => 'required|array|min:1',
            'addresses.*.living_arrangement' => 'required|in:owner,renting_agent,renting_privately,with_parents,sharing,other',
            'addresses.*.address' => 'required|string',
            'addresses.*.years_lived' => 'required|integer|min:0',
            'addresses.*.months_lived' => 'required|integer|min:0|max:11',
            'addresses.*.reason_for_leaving' => 'nullable|string',
            'addresses.*.different_postal_address' => 'boolean',
            'addresses.*.postal_code' => 'nullable|string|required_if:addresses.*.different_postal_address,true',
            'addresses.*.is_current' => 'boolean',
        ]);

        // Delete existing addresses
        $user->addresses()->delete();

        foreach ($validated['addresses'] as $addressData) {
            $address = new UserAddress($addressData);
            $address->user_id = $user->id;
            $address->save();
        }

        $user->profile_current_step = 8;
        $user->save();

        return response()->json(['success' => true, 'next_step' => 8]);
    }

    private function saveStep8(Request $request, $user)
    {
        $hasReferences = $request->input('has_references', false);

        if (!$hasReferences) {
            $user->profile_current_step = 9;
            $user->save();
            return response()->json(['success' => true, 'next_step' => 9]);
        }

        $validated = $request->validate([
            'references' => 'required|array|min:1',
            'references.*.full_name' => 'required|string|max:255',
            'references.*.relationship' => 'required|string|max:255',
            'references.*.mobile_country_code' => 'required|string',
            'references.*.mobile_number' => 'required|string',
            'references.*.email' => 'required|email',
        ]);

        // Delete existing references
        $user->references()->delete();

        foreach ($validated['references'] as $referenceData) {
            $reference = new UserReference($referenceData);
            $reference->user_id = $user->id;
            $reference->save();
        }

        $user->profile_current_step = 9;
        $user->save();

        return response()->json(['success' => true, 'next_step' => 9]);
    }

    private function saveStep9(Request $request, $user)
    {
        $validated = $request->validate([
            'identifications' => 'required|array|min:1',
            'identifications.*.identification_type' => 'required|in:australian_drivers_licence,passport,birth_certificate,medicare,other',
            'identifications.*.document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'identifications.*.expiry_date' => 'nullable|date',
        ]);

        // Delete existing identifications
        $user->identifications()->delete();

        foreach ($validated['identifications'] as $index => $idData) {
            $identification = new UserIdentification();
            $identification->user_id = $user->id;
            $identification->identification_type = $idData['identification_type'];
            $identification->points = UserIdentification::getPointsForType($idData['identification_type']);
            $identification->expiry_date = $idData['expiry_date'] ?? null;
            
            if ($request->hasFile("identifications.$index.document")) {
                $path = $request->file("identifications.$index.document")
                    ->store('identification-documents', 'public');
                $identification->document_path = $path;
            }
            
            $identification->save();
        }

        // Check if user has minimum 80 points
        $totalPoints = $user->identifications()->sum('points');
        if ($totalPoints < 80) {
            return response()->json([
                'success' => false,
                'error' => 'You must supply at least 80 ID Points for your application to be considered.',
                'total_points' => $totalPoints
            ], 422);
        }

        $user->profile_current_step = 10;
        $user->save();

        return response()->json(['success' => true, 'next_step' => 10]);
    }

    private function saveStep10(Request $request, $user)
    {
        $validated = $request->validate([
            'terms_accepted' => 'required|accepted',
            'signature' => 'required|string|max:255',
        ]);

        $profile = $user->profile;
        $profile->terms_accepted = true;
        $profile->signature = $validated['signature'];
        $profile->terms_accepted_at = now();
        $profile->status = 'pending'; // Submit for admin approval
        $profile->submitted_at = now();
        $profile->save();

        $user->profile_current_step = 10;
        $user->save();

        // ==================== SEND ADMIN EMAIL NOTIFICATION ====================
        $this->sendAdminNotification($user, $profile);

        return response()->json([
            'success' => true,
            'message' => 'Profile submitted successfully! Waiting for admin approval.',
            'redirect' => route('user.profile.view')
        ]);
    }

    /**
     * Send email notification to admin when profile is submitted
     */
    private function sendAdminNotification($user, $profile)
    {
        try {
            // Get admin email from config or use default
            $adminEmail = config('mail.admin_email', 'admin@sorted.com');
            
            // Send notification email
            Mail::to($adminEmail)->send(new ProfileSubmittedNotification($user, $profile));
            
            Log::info('Admin notification sent for user profile', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'admin_email' => $adminEmail
            ]);
        } catch (\Exception $e) {
            // Log error but don't fail the submission
            Log::error('Failed to send admin notification email', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * View submitted profile (read-only)
     */
    public function view()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return redirect()->route('user.profile.complete')
                ->with('error', 'Please complete your profile first.');
        }

        return view('user.profile.view', compact('user', 'profile'));
    }

    public function previousStep(Request $request)
    {
        $user = Auth::user();
        $currentStep = $user->profile_current_step;

        if ($currentStep > 1) {
            $user->profile_current_step = $currentStep - 1;
            $user->save();
        }

        return response()->json([
            'success' => true,
            'previous_step' => $user->profile_current_step
        ]);
    }
}