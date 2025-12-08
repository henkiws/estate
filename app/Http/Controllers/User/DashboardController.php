<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display user dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get statistics
        $stats = [
            'saved_properties' => $user->savedProperties()->count(),
            'applications' => $user->propertyApplications()->count(),
            'pending_applications' => $user->propertyApplications()->where('status', 'pending')->count(),
            'enquiries' => $user->propertyEnquiries()->count(),
        ];
        
        // Get recent activity
        $recentSaved = $user->savedProperties()
            ->with(['agency', 'featuredImage'])
            ->latest('saved_properties.created_at')
            ->take(4)
            ->get();
        
        $recentApplications = $user->propertyApplications()
            ->with(['property.agency', 'property.featuredImage'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('user.dashboard', compact('stats', 'recentSaved', 'recentApplications'));
    }
}