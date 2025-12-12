<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use App\Models\UserProfileHistory;
use App\Mail\ProfileApprovedMail;
use App\Mail\ProfileRejectedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ProfileApprovalController extends Controller
{
    /**
     * Display a listing of user profiles
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $profiles = UserProfile::with(['user', 'user.identifications'])
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest('submitted_at')
            ->paginate(20);

        $counts = [
            'pending' => UserProfile::where('status', 'pending')->count(),
            'approved' => UserProfile::where('status', 'approved')->count(),
            'rejected' => UserProfile::where('status', 'rejected')->count(),
        ];

        return view('admin.profiles.index', compact('profiles', 'status', 'counts'));
    }

    /**
     * Display the specified profile for review
     */
    public function show($id)
    {
        $profile = UserProfile::with([
            'user',
            'user.identifications',
            'user.incomes',
            'user.employments',
            'user.pets',
            'user.vehicles',
            'user.addresses',
            'user.references',
            'histories.admin' // Load approval history
        ])->findOrFail($id);

        // Calculate total ID points
        $totalPoints = $profile->user->identifications->sum('points') ?? 0;

        // Log for debugging
        Log::info('Profile Review', [
            'profile_id' => $profile->id,
            'user_id' => $profile->user_id,
            'identifications_count' => $profile->user->identifications->count(),
            'total_points' => $totalPoints
        ]);

        return view('admin.profiles.show', compact('profile', 'totalPoints'));
    }

    /**
     * Approve a user profile
     */
    public function approve($id)
    {
        try {
            $profile = UserProfile::with('user')->findOrFail($id);

            // Store previous status
            $previousStatus = $profile->status;

            // Update profile status
            $profile->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
                'rejected_at' => null,
                'rejected_by' => null,
                'rejection_reason' => null,
            ]);

            // Update user's profile_completed status
            $profile->user->update([
                'profile_completed' => true
            ]);

            // ==================== CREATE HISTORY RECORD ====================
            UserProfileHistory::create([
                'user_profile_id' => $profile->id,
                'user_id' => $profile->user_id,
                'admin_id' => auth()->id(),
                'action' => 'approved',
                'previous_status' => $previousStatus,
                'new_status' => 'approved',
                'reason' => null, // No reason needed for approval
                'admin_notes' => 'Profile approved by admin',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Send approval email via queue
            Mail::to($profile->user->email)
                ->queue(new ProfileApprovedMail($profile->user, $profile));

            Log::info('Profile Approved', [
                'profile_id' => $profile->id,
                'user_id' => $profile->user_id,
                'user_email' => $profile->user->email,
                'approved_by' => auth()->id(),
                'approved_by_name' => auth()->user()->name
            ]);

            return redirect()
                ->route('admin.profiles.index')
                ->with('success', 'Profile approved successfully! Approval email has been queued and will be sent shortly.');

        } catch (\Exception $e) {
            Log::error('Profile Approval Error', [
                'profile_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to approve profile. Please try again.');
        }
    }

    /**
     * Reject a user profile
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500',
            'admin_notes' => 'nullable|string|max:1000' // Optional private notes
        ]);

        try {
            $profile = UserProfile::with('user')->findOrFail($id);

            // Store previous status
            $previousStatus = $profile->status;

            // Update profile status
            $profile->update([
                'status' => 'rejected',
                'rejected_at' => now(),
                'rejected_by' => auth()->id(),
                'rejection_reason' => $request->rejection_reason,
                'approved_at' => null,
                'approved_by' => null,
            ]);

            // Update user's profile_completed status
            $profile->user->update([
                'profile_completed' => false
            ]);

            // ==================== CREATE HISTORY RECORD ====================
            UserProfileHistory::create([
                'user_profile_id' => $profile->id,
                'user_id' => $profile->user_id,
                'admin_id' => auth()->id(),
                'action' => 'rejected',
                'previous_status' => $previousStatus,
                'new_status' => 'rejected',
                'reason' => $request->rejection_reason,
                'admin_notes' => $request->admin_notes,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Send rejection email via queue
            Mail::to($profile->user->email)
                ->queue(new ProfileRejectedMail($profile->user, $profile));

            Log::info('Profile Rejected', [
                'profile_id' => $profile->id,
                'user_id' => $profile->user_id,
                'user_email' => $profile->user->email,
                'rejected_by' => auth()->id(),
                'rejected_by_name' => auth()->user()->name,
                'reason' => $request->rejection_reason
            ]);

            return redirect()
                ->route('admin.profiles.index')
                ->with('success', 'Profile rejected and user has been notified via email.');

        } catch (\Exception $e) {
            Log::error('Profile Rejection Error', [
                'profile_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to reject profile. Please try again.');
        }
    }

    /**
     * Display approval history for a profile
     */
    public function history($id)
    {
        $profile = UserProfile::with([
            'user',
            'histories' => function($query) {
                $query->with('admin')->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        return view('admin.profiles.history', compact('profile'));
    }
}