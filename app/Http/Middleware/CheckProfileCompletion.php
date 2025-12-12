<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileCompletion
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip check if user is not a regular user (admin, agent, agency)
        if (!$user || !$user->hasRoleUser()) {
            return $next($request);
        }

        // Check if profile exists and is approved
        if ($user->needsProfileCompletion()) {
            // Allow access to profile completion routes
            if ($request->routeIs('user.profile.*')) {
                return $next($request);
            }

            // Redirect to profile completion
            return redirect()->route('user.profile.complete')
                ->with('warning', 'Please complete your profile before accessing other features.');
        }

        return $next($request);
    }
}