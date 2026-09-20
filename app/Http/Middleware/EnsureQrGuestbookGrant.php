<?php

namespace App\Http\Middleware;

use App\Models\GuestbookGrant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureQrGuestbookGrant
{
    public const SESSION_KEY = 'guestbook_qr_grant';

    public const BINDING_KEY = 'guestbook_qr_binding';

    public function handle(Request $request, Closure $next): Response
    {
        $rawToken = $request->session()->get(self::SESSION_KEY);
        $sessionBinding = $request->session()->get(self::BINDING_KEY);
        $grant = is_string($rawToken) && $rawToken !== ''
            && is_string($sessionBinding) && $sessionBinding !== ''
            ? GuestbookGrant::query()
                ->where('token_hash', hash('sha256', $rawToken))
                ->where('session_hash', hash('sha256', $sessionBinding))
                ->first()
            : null;

        if (! $grant?->isAvailable()) {
            $request->session()->forget([self::SESSION_KEY, self::BINDING_KEY]);

            return response()->view('tamu.qr-unavailable', status: 403);
        }

        $request->attributes->set('guestbookGrant', $grant);

        return $next($request);
    }
}
