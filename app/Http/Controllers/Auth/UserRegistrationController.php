<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserRegistrationController extends Controller
{
    /**
     * Display the user registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register-user');
    }

    /**
     * Handle user registration request.
     */
    public function register(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            // Personal Details
            'title' => ['required', 'string', 'in:Mr,Ms,Mrs,Miss,Dr,Prof,Other'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:-18 years'],
            
            // Contact Information
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_country_code' => ['required', 'string', 'max:5'],
            'mobile_number' => ['required', 'string', 'regex:/^[0-9]{8,10}$/'],
            
            // Account Security
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            // Terms
            'terms_accepted' => ['required', 'accepted'],
        ]);

        try {
            DB::beginTransaction();

            // Create the user account
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Assign 'user' role (default role for regular users)
            $user->assignRole('user');

            // Create the user profile
            UserProfile::create([
                'user_id' => $user->id,
                'status' => 'draft', // Initial status
                
                // Personal Details
                'title' => $validated['title'],
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'surname' => $validated['surname'] ?? null,
                'date_of_birth' => $validated['date_of_birth'],
                
                // Contact Information
                'email' => $validated['email'],
                'mobile_country_code' => $validated['mobile_country_code'],
                'mobile_number' => $validated['mobile_number'],
                
                // Terms
                'terms_accepted' => true,
                'terms_accepted_at' => now(),
            ]);

            DB::commit();

            // Fire the Registered event (for email verification)
            event(new Registered($user));

            // Log the user in
            Auth::login($user);

            // Redirect to email verification notice
            return redirect()->route('verification.notice')
                ->with('success', 'Account created successfully! Please verify your email address to continue.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withErrors(['error' => 'Registration failed. Please try again.'])
                ->withInput();
        }
    }

    /**
     * AJAX endpoint to check if email is available.
     * 
     * @param string $email
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkEmail($email)
    {
        $exists = User::where('email', $email)->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Email already taken' : 'Email available'
        ]);
    }
}