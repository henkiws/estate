<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Update user's preferred state
     */
    public function updateState(Request $request)
    {
        $request->validate([
            'preferred_state' => 'required|string|in:ACT,NSW,SA,TAS,QLD,VIC,WA,NT',
        ]);
        
        Auth::user()->update([
            'preferred_state' => $request->preferred_state,
        ]);
        
        return back()->with('success', 'Preferred state updated successfully');
    }
}