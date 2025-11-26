<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgencyRegistrationRequest;
use App\Repositories\AgencyRepository;
use App\Mail\AgencyRegistered;
use App\Mail\NewAgencyNotification;
use App\Models\User;
use App\Models\AgencyDocumentRequirement;
use App\Models\ActivityLog;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            DB::beginTransaction();

            // Create agency with all related data
            $agency = $this->agencyRepository->createAgency($request->validated());

            // Create document requirements for the agency
            $this->createDocumentRequirements($agency);

            // Get the created user (agency admin)
            $user = $agency->users[0];

            // Log the registration activity
            ActivityLog::log(
                "New agency registered",
                $agency,
                [
                    'agency_name' => $agency->agency_name,
                    'abn' => $agency->abn,
                    'state' => $agency->state,
                    'business_email' => $agency->business_email,
                ]
            );

            Log::info('New agency registered', [
                'agency_id' => $agency->id,
                'agency_name' => $agency->agency_name,
                'abn' => $agency->abn,
            ]);

            DB::commit();

            // Fire the registered event (this will send email verification)
            event(new Registered($user));

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

            // Redirect with success message
            return redirect()
                ->route('verification.notice')
                ->with('success', 'Registration successful! Please verify your email address to continue.');

        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Agency registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Registration failed: ' . $e->getMessage() . '. Please try again or contact support.');
        }
    }

    /**
     * Create document requirements for agency
     */
    protected function createDocumentRequirements($agency): void
    {
        $documents = [
            [
                'name' => 'Real Estate Agency License Certificate',
                'description' => 'Valid real estate agency license issued by your state regulatory authority',
                'is_required' => true,
            ],
            [
                'name' => 'Proof of Identity - Principal/Licensee',
                'description' => 'Driver\'s license, passport, or other government-issued ID of the principal licensee',
                'is_required' => true,
            ],
            [
                'name' => 'ABN Registration Certificate',
                'description' => 'Australian Business Number registration document from the ATO',
                'is_required' => true,
            ],
            [
                'name' => 'Professional Indemnity Insurance',
                'description' => 'Current professional indemnity insurance certificate of currency',
                'is_required' => true,
            ],
            [
                'name' => 'Public Liability Insurance',
                'description' => 'Current public liability insurance certificate of currency',
                'is_required' => true,
            ],
        ];

        foreach ($documents as $doc) {
            AgencyDocumentRequirement::create([
                'agency_id' => $agency->id,
                'name' => $doc['name'],
                'description' => $doc['description'],
                'is_required' => $doc['is_required'],
                'status' => 'pending',
            ]);
        }

        Log::info('Document requirements created for agency', [
            'agency_id' => $agency->id,
            'document_count' => count($documents),
        ]);
    }

    /**
     * Check if ABN exists (AJAX)
     */
    public function checkABN(string $abn)
    {
        // Remove spaces
        $abn = str_replace(' ', '', $abn);
        
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