<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgencyRegistrationRequest;
use App\Repositories\AgencyRepository;
use App\Mail\AgencyRegistered;
use App\Mail\NewAgencyNotification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Exception;

class AgencyRegistrationController extends Controller
{
    public function __construct(
        protected AgencyRepository $agencyRepository
    ) {}

    /**
     * Show the agency registration form
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register-agency');
    }

    /**
     * Handle agency registration
     */
    public function register(AgencyRegistrationRequest $request): RedirectResponse
    {
        try {
            // Create agency with all related data
            $agency = $this->agencyRepository->createAgency($request->validated());

            // Log the registration
            Log::info('New agency registered', [
                'agency_id' => $agency->id,
                'agency_name' => $agency->agency_name,
                'abn' => $agency->abn,
            ]);

            // Get the created user (agency admin)
            $user = $agency->users()->first();

            // Send email to agency
            try {
                Mail::to($user->email)->send(new AgencyRegistered($agency));
                Log::info('Registration email sent to agency', ['email' => $user->email]);
            } catch (Exception $e) {
                Log::error('Failed to send registration email to agency', [
                    'error' => $e->getMessage(),
                    'email' => $user->email,
                ]);
            }

            // Send notification to all admins
            try {
                $admins = User::role('admin')->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new NewAgencyNotification($agency));
                }
                Log::info('New agency notification sent to admins', ['admin_count' => $admins->count()]);
            } catch (Exception $e) {
                Log::error('Failed to send admin notification', ['error' => $e->getMessage()]);
            }

            // Log the user in
            Auth::login($user);

            // Redirect to dashboard with success message
            return redirect()
                ->route('agency.dashboard')
                ->with('success', 'Registration successful! Your agency is pending approval. You will receive an email once approved.');

        } catch (Exception $e) {
            Log::error('Agency registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Registration failed. Please try again or contact support.']);
        }
    }

    /**
     * Check if ABN exists (AJAX)
     */
    public function checkABN(string $abn)
    {
        $exists = $this->agencyRepository->abnExists($abn);
        
        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'This ABN is already registered.' : 'ABN is available.'
        ]);
    }

    /**
     * Check if license number exists (AJAX)
     */
    public function checkLicense(string $licenseNumber)
    {
        $exists = $this->agencyRepository->licenseExists($licenseNumber);
        
        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'This license number is already registered.' : 'License number is available.'
        ]);
    }

    /**
     * Check if business email exists (AJAX)
     */
    public function checkBusinessEmail(string $email)
    {
        $exists = $this->agencyRepository->emailExists($email);
        
        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'This business email is already registered.' : 'Email is available.'
        ]);
    }
}