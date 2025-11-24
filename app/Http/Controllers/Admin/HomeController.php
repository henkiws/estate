<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AgencyRepository;

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
        
        // Get pending agencies for the widget
        $pendingAgencies = $this->agencyRepository->getByStatus('pending', 100);
        
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