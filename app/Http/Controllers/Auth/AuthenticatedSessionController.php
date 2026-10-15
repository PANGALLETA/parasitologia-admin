<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\SessionGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        /** @var SessionGuard $guard */
        $guard = Auth::guard('web');
        $guard->logoutOtherDevices($request->input('password'));

        // Protect this session even before its first authenticated page request.
        $request->session()->put(
            'password_hash_web',
            $guard->hashPasswordForCookie($request->user()->getAuthPassword())
        );

        // Also revoke database sessions created before session authentication was enabled.
        if (config('session.driver') === 'database') {
            DB::connection(config('session.connection'))
                ->table(config('session.table', 'sessions'))
                ->where('user_id', $request->user()->getAuthIdentifier())
                ->where('id', '!=', $request->session()->getId())
                ->delete();
        }

        if ($request->user()->hasRole('Estudiante')) {

            return redirect()->route('parasitos.index');

        }

        $prefix = trim(
            (string) request()->header('X-Forwarded-Prefix', ''),
            '/'
        );

        $url = ($prefix !== '' ? '/'.$prefix : '').'/dashboard';

        return redirect($url);
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
