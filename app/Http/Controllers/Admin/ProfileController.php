<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the admin's profile.
     */
    public function show()
    {
        $user = Auth::user();
        
        return view('admin.profile.show', compact('user'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        
        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Update the admin's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'position' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        // Check if email changed
        if ($validated['email'] !== $user->email) {
            $validated['email_verified_at'] = null;
        }

        $user->update($validated);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the admin's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Upload profile picture.
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'], // 2MB max
        ]);

        $user = Auth::user();

        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update(['avatar' => $path]);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profile picture updated successfully!');
    }

    /**
     * Remove profile picture.
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profile picture removed successfully!');
    }

    /**
     * Show account settings.
     */
    public function settings()
    {
        $user = Auth::user();
        
        return view('admin.profile.settings', compact('user'));
    }

    /**
     * Update account settings/preferences.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'timezone' => ['nullable', 'string', 'max:255'],
            'language' => ['nullable', 'string', 'max:10'],
            'date_format' => ['nullable', 'string', 'max:50'],
            'time_format' => ['nullable', 'string', 'max:50'],
            'notifications_email' => ['boolean'],
            'notifications_browser' => ['boolean'],
        ]);

        $user = Auth::user();

        // Store preferences in JSON field or separate settings table
        $settings = $user->settings ?? [];
        $settings = array_merge($settings, $validated);

        $user->update(['settings' => $settings]);

        return redirect()->route('admin.profile.settings')
            ->with('success', 'Settings updated successfully!');
    }

    /**
     * Show security settings.
     */
    public function security()
    {
        $user = Auth::user();
        
        // Get recent login activity (you can implement this based on your needs)
        $recentLogins = []; // Placeholder for login history
        
        return view('admin.profile.security', compact('user', 'recentLogins'));
    }

    /**
     * Enable two-factor authentication.
     */
    public function enableTwoFactor(Request $request)
    {
        // Implement 2FA logic here
        // This is a placeholder for future implementation
        
        return redirect()->route('admin.profile.security')
            ->with('success', 'Two-factor authentication enabled successfully!');
    }

    /**
     * Disable two-factor authentication.
     */
    public function disableTwoFactor(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        // Implement 2FA disable logic here
        
        return redirect()->route('admin.profile.security')
            ->with('success', 'Two-factor authentication disabled successfully!');
    }

    /**
     * Show activity log.
     */
    public function activity()
    {
        $user = Auth::user();
        
        // Get user activity log
        // This is a placeholder - you can implement activity tracking
        $activities = [];
        
        return view('admin.profile.activity', compact('user', 'activities'));
    }
}