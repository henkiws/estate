<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in
        if (Auth::check()) {
            $user = Auth::user();
            
            // If email is not verified, logout and redirect
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                
                return redirect()->route('login')
                    ->with('error', 'Please verify your email address before logging in. Check your inbox for the verification link.');
            }
        }
        
        return $next($request);
    }
}