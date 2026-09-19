<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (! Auth::guard($guard)->check()) {
                continue;
            }

            return match (Auth::guard($guard)->user()->role) {
                User::ROLE_GUEST => redirect()->route('tamu.create'),
                User::ROLE_SUPERADMIN => redirect()->route('dashboard.index'),
                default => redirect()->route('home'),
            };
        }

        return $next($request);
    }
}
