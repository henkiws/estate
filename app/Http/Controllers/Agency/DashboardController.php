<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $agency = auth()->user()->agency;
        
        // Load relationships
        if ($agency) {
            $agency->load(['agents', 'contacts', 'services', 'branding']);
        }
        
        return view('agency.dashboard', compact('agency'));
    }
}