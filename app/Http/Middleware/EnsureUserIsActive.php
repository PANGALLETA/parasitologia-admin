<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && ! $request->user()->activo) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Su cuenta está desactivada.',
                ], 403);
            }

            return redirect()->route('login')->withErrors([
                'email' => 'Su cuenta está desactivada. Contacte al administrador.',
            ]);
        }

        return $next($request);
    }
}
