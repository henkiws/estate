<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get or create user profile
        $profile = $user->profile;
        
        // Calculate profile completion percentage
        $profileCompletion = $this->calculateProfileCompletion($user, $profile);
        
        // Get completion status for each step
        $steps = $this->getStepsCompletion($user, $profile);
        
        // Calculate total ID points
        $idPoints = $user->identifications->sum('points') ?? 0;
        
        return view('user.dashboard', compact(
            'profileCompletion',
            'steps',
            'idPoints'
        ));
    }
    
    /**
     * Calculate overall profile completion percentage
     */
    private function calculateProfileCompletion($user, $profile)
    {
        $totalSteps = 10;
        $completedSteps = 0;
        
        // Step 1: Personal Details (profile exists with required fields)
        if ($profile && $profile->first_name && $profile->last_name && $profile->date_of_birth) {
            $completedSteps++;
        }
        
        // Step 2: Introduction
        if ($profile && $profile->introduction) {
            $completedSteps++;
        }
        
        // Step 3: Income (at least one income source)
        if ($user->incomes && $user->incomes->count() > 0) {
            $completedSteps++;
        }
        
        // Step 4: Employment (at least one employment)
        if ($user->employments && $user->employments->count() > 0) {
            $completedSteps++;
        }
        
        // Step 5: Pets (optional, but if has_pets flag exists)
        // Consider complete if they've addressed it (even if no pets)
        $completedSteps++; // Auto-complete this as it's optional
        
        // Step 6: Vehicles (optional)
        // Consider complete if they've addressed it
        $completedSteps++; // Auto-complete this as it's optional
        
        // Step 7: Address History (at least one address)
        if ($user->addresses && $user->addresses->count() > 0) {
            $completedSteps++;
        }
        
        // Step 8: References (at least 2 references)
        if ($user->references && $user->references->count() >= 2) {
            $completedSteps++;
        }
        
        // Step 9: Identification (at least 80 points)
        $idPoints = $user->identifications->sum('points') ?? 0;
        if ($idPoints >= 80) {
            $completedSteps++;
        }
        
        // Step 10: Terms & Conditions
        if ($profile && $profile->terms_accepted) {
            $completedSteps++;
        }
        
        // Calculate percentage
        $percentage = ($completedSteps / $totalSteps) * 100;
        
        return round($percentage);
    }
    
    /**
     * Get completion status for each major step
     */
    private function getStepsCompletion($user, $profile)
    {
        $idPoints = $user->identifications->sum('points') ?? 0;
        
        return [
            'personal' => $profile && $profile->first_name && $profile->last_name && $profile->date_of_birth,
            'income' => $user->incomes && $user->incomes->count() > 0,
            'employment' => $user->employments && $user->employments->count() > 0,
            'identification' => $idPoints >= 80,
        ];
    }
}