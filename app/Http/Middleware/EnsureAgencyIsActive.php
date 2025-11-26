<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAgencyIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Check if user has agency
        if (!$user->agency) {
            return redirect()->route('register.agency')
                ->with('error', 'Please complete your agency registration.');
        }

        $agency = $user->agency;

        // Check agency status
        if ($agency->status !== 'active') {
            return redirect()->route('agency.dashboard')
                ->with('warning', 'This feature is only available for active agencies with subscriptions.');
        }

        return $next($request);
    }
}