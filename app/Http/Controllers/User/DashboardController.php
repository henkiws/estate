<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Check if profile needs completion
        if ($user->needsProfileCompletion()) {
            return redirect()->route('user.profile.complete');
        }

        // Get user statistics
        $stats = [
            'saved_properties' => $user->savedProperties()->count(),
            'applications' => $user->applications()->count(),
            'pending_applications' => $user->applications()->where('status', 'pending')->count(),
            'enquiries' => $user->enquiries()->count(),
        ];

        // Get recent activities
        $recentApplications = $user->applications()
            ->with(['property', 'property.agency'])
            ->latest()
            ->take(5)
            ->get();

        $savedProperties = $user->savedProperties()
            ->with(['agency'])
            ->latest('saved_properties.created_at')
            ->take(6)
            ->get();

        return view('user.dashboard', compact('user', 'stats', 'recentApplications', 'savedProperties'));
    }
}