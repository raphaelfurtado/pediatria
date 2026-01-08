<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // If no roles passed, just check if authenticated (already done above)
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user has one of the allowed roles
        // Assuming 'role' column exists on users table
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Allow admin to access everything
        if ($user->role === 'admin') {
            return $next($request);
        }

        abort(403, 'Acesso não autorizado.');
    }
}
