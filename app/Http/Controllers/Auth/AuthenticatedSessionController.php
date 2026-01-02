<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        // Store intended URL if redirect parameter exists
        if ($request->has('redirect')) {
            session(['url.intended' => $request->get('redirect')]);
        }
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check if there's an intended URL in session (from redirect parameter)
        if (session()->has('url.intended')) {
            $intended = session()->pull('url.intended');
            return redirect($intended)->with('success', 'Welcome back!');
        }

        // Otherwise, redirect based on user role
        return $this->redirectBasedOnRole();
    }

    /**
     * Redirect user to appropriate dashboard based on their role
     */
    protected function redirectBasedOnRole(): RedirectResponse
    {
        $user = Auth::user();

        // dd($user->roles->pluck('name'));

        // Check if user has a role
        if ($user->hasRole('admin')) {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->hasRole('agency')) {
            // Check if agency is active
            if ($user->agency && $user->agency->status !== 'active') {
                return redirect()->route('agency.dashboard')
                    ->with('warning', 'Your agency is pending approval. Some features may be limited.');
            }
            return redirect()->intended(route('agency.dashboard'));
        }

        if ($user->hasRole('agent')) {
            return redirect()->intended(route('agent.dashboard'));
        }

        if ($user->hasRole('user')) {
            return redirect()->intended(route('user.dashboard'));
        }

        // Default fallback if no role is assigned
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}