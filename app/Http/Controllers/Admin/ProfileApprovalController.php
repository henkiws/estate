<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ProfileApprovalController extends Controller
{
    /**
     * Display a listing of profiles
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $profiles = UserProfile::with(['user', 'user.identifications'])
            ->where('status', $status)
            ->orderBy('submitted_at', 'desc')
            ->paginate(20);

        // Get counts for filter badges
        $pendingCount = UserProfile::where('status', 'pending')->count();
        $approvedCount = UserProfile::where('status', 'approved')->count();
        $rejectedCount = UserProfile::where('status', 'rejected')->count();

        return view('admin.profiles.index', compact(
            'profiles',
            'status',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    /**
     * Display the specified profile for review
     */
    public function show($id)
    {
        $profile = UserProfile::with([
            'user',
            'user.incomes',
            'user.employments',
            'user.pets',
            'user.vehicles',
            'user.addresses',
            'user.references',
            'user.identifications'
        ])->findOrFail($id);

        // Calculate total ID points - ENSURE this is set
        $totalPoints = $profile->user->identifications->sum('points') ?? 0;

        return view('admin.profiles.show', compact('profile', 'totalPoints'));
    }

    /**
     * Approve a profile
     */
    public function approve(Request $request, $id)
    {
        $profile = UserProfile::findOrFail($id);
        $user = $profile->user;

        $profile->status = 'approved';
        $profile->approved_at = now();
        $profile->approved_by = auth()->id();
        $profile->save();

        // Mark user profile as completed
        $user->profile_completed = true;
        $user->save();

        // Send approval email to user (optional)
        // $this->sendApprovalEmail($user, $profile);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile approved successfully!'
            ]);
        }

        return redirect()->route('admin.profiles.index')
            ->with('success', "Profile for {$user->name} has been approved!");
    }

    /**
     * Reject a profile
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500'
        ]);

        $profile = UserProfile::findOrFail($id);
        $user = $profile->user;

        $profile->status = 'rejected';
        $profile->rejection_reason = $request->rejection_reason;
        $profile->rejected_at = now();
        $profile->rejected_by = auth()->id();
        $profile->save();

        // Keep user profile as incomplete
        $user->profile_completed = false;
        $user->save();

        // Send rejection email to user (optional)
        // $this->sendRejectionEmail($user, $profile);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile rejected successfully!'
            ]);
        }

        return redirect()->route('admin.profiles.index')
            ->with('success', "Profile for {$user->name} has been rejected.");
    }

    /**
     * Send approval email to user (implement if needed)
     */
    private function sendApprovalEmail(User $user, UserProfile $profile)
    {
        try {
            // You can create a ProfileApprovedMail class similar to ProfileSubmittedNotification
            // Mail::to($user->email)->send(new ProfileApprovedMail($user, $profile));
            
            Log::info('Approval email sent to user', [
                'user_id' => $user->id,
                'profile_id' => $profile->id
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send approval email: ' . $e->getMessage());
        }
    }

    /**
     * Send rejection email to user (implement if needed)
     */
    private function sendRejectionEmail(User $user, UserProfile $profile)
    {
        try {
            // You can create a ProfileRejectedMail class
            // Mail::to($user->email)->send(new ProfileRejectedMail($user, $profile));
            
            Log::info('Rejection email sent to user', [
                'user_id' => $user->id,
                'profile_id' => $profile->id
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send rejection email: ' . $e->getMessage());
        }
    }
}