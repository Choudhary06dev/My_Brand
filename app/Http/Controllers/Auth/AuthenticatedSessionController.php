<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    use LogsActivity;

    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        return $request->is('admin/*') ? view('auth.login') : view('frontend.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Determine guard
        $guard = $request->is('admin/login') ? 'admin' : 'web';

        // Authenticate user
        $request->authenticate($guard);

        // Regenerate session
        $request->session()->regenerate();

        // Log activity
        $this->logActivity('Login', 'User logged in successfully');

        // Redirect based on request path
        if ($request->is('admin/login')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Determine if this is an admin logout request
        $isAdmin = $request->is('admin/*') || $request->routeIs('admin.*');
        $guard = $isAdmin ? 'admin' : 'web';

        // Log activity before session is cleared
        $this->logActivity('Logout', ($isAdmin ? 'Admin' : 'User') . ' logged out');

        // Logout from specific guard
        Auth::guard($guard)->logout();

        // Check if other guard is still authenticated
        $otherGuard = $isAdmin ? 'web' : 'admin';
        $otherActive = Auth::guard($otherGuard)->check();

        if (!$otherActive) {
            // Only invalidate the full session and regenerate token if NO guards are active
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } else {
            // If the other guard is still active, just regenerate the CSRF token to be safe
            // but keep the session data (like the other guard's login state)
            $request->session()->regenerateToken();
        }

        if ($isAdmin) {
            return Route::has('admin.login')
                ? redirect()->route('admin.login')
                : redirect('/admin/login');
        }

        // Default frontend redirect - use route name to ensure it stays on the correct domain/base path
        return redirect()->route('home');
    }
}
