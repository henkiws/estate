<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AgencyRepository;
use App\Models\Agency;
use App\Models\UserProfile;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct(
        protected AgencyRepository $agencyRepository
    ) {}

    public function index()
    {
        // Get statistics for dashboard
        $stats = $this->agencyRepository->getStatistics();
        $stateStats = $this->agencyRepository->getStatisticsByState();
        
        // Get pending agencies for the widget WITH document requirements
        $pendingAgencies = Agency::where('status', 'pending')
            ->with('documentRequirements')
            ->latest()
            ->get();
        
        // Get recent agencies
        $recentAgencies = $this->agencyRepository->getAllPaginated(5);

        // ==================== USER PROFILE APPROVAL INTEGRATION ====================
        
        // Get pending user profiles for approval
        $pendingProfiles = UserProfile::with(['user', 'user.identifications'])
            ->where('status', 'pending')
            ->orderBy('submitted_at', 'desc')
            ->get();
        
        // Count of pending user profiles
        $pendingProfilesCount = $pendingProfiles->count();
        
        // Get recent profile submissions (last 5)
        $recentProfiles = UserProfile::with(['user', 'user.identifications'])
            ->where('status', 'pending')
            ->orderBy('submitted_at', 'desc')
            ->limit(5)
            ->get();

        // User profile statistics
        $profileStats = [
            'pending' => UserProfile::where('status', 'pending')->count(),
            'approved' => UserProfile::where('status', 'approved')->count(),
            'rejected' => UserProfile::where('status', 'rejected')->count(),
            'total_users' => User::role('user')->count(),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'stateStats',
            'pendingAgencies',
            'recentAgencies',
            'pendingProfiles',
            'pendingProfilesCount',
            'recentProfiles',
            'profileStats'
        ));
    }
}