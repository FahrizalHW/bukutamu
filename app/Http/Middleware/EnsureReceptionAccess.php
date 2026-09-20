<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureReceptionAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless(
            in_array($request->user()?->role, [User::ROLE_OPERATOR, User::ROLE_SUPERADMIN], true),
            403
        );

        return $next($request);
    }
}
