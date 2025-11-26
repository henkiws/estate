<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AgencyRepository;
use App\Models\Agency;

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
            ->with('documentRequirements')  // ← ADD THIS
            ->latest()
            ->get();
        
        // Get recent agencies
        $recentAgencies = $this->agencyRepository->getAllPaginated(5);

        return view('admin.dashboard', compact(
            'stats',
            'stateStats',
            'pendingAgencies',
            'recentAgencies'
        ));
    }
}