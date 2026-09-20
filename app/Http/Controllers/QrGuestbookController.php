<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EnsureQrGuestbookGrant;
use App\Http\Requests\StoreTamuRequest;
use App\Models\GuestbookGrant;
use App\Models\Tamu;
use App\Services\GuestVisitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\View\View;
use LogicException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class QrGuestbookController extends Controller
{
    public function __construct(private readonly GuestVisitService $guestVisitService) {}

    public function display(): View
    {
        return view('reception.qr', ['qrTtlSeconds' => $this->qrTtlSeconds()]);
    }

    public function token(): JsonResponse
    {
        $ttl = $this->qrTtlSeconds();
        $expiresAt = now()->addSeconds($ttl);

        return response()->json([
            'url' => URL::temporarySignedRoute('tamu.qr.enter', $expiresAt),
            'expires_at' => $expiresAt->toIso8601String(),
            'ttl_seconds' => $ttl,
        ])->header('Cache-Control', 'no-store, private');
    }

    public function enter(Request $request): RedirectResponse|Response
    {
        if (! $request->hasValidSignature()) {
            return response()->view('tamu.qr-unavailable', status: 403);
        }

        $rawToken = Str::random(64);
        $sessionBinding = $request->session()->get(EnsureQrGuestbookGrant::BINDING_KEY);

        if (! is_string($sessionBinding) || $sessionBinding === '') {
            $sessionBinding = Str::random(48);
            $request->session()->put(EnsureQrGuestbookGrant::BINDING_KEY, $sessionBinding);
        }

        $sessionHash = hash('sha256', $sessionBinding);

        GuestbookGrant::query()
            ->where('session_hash', $sessionHash)
            ->whereNull('used_at')
            ->delete();

        GuestbookGrant::create([
            'token_hash' => hash('sha256', $rawToken),
            'session_hash' => $sessionHash,
            'expires_at' => now()->addMinutes($this->grantTtlMinutes()),
        ]);

        $request->session()->put(EnsureQrGuestbookGrant::SESSION_KEY, $rawToken);

        return redirect()->route('tamu.qr.form');
    }

    public function create(Request $request): View
    {
        /** @var GuestbookGrant $grant */
        $grant = $request->attributes->get('guestbookGrant');

        return view('tamu.create', [
            'mode' => 'qr',
            'formAction' => route('tamu.qr.store'),
            'grantExpiresAt' => $grant->expires_at,
        ]);
    }

    public function store(StoreTamuRequest $request): RedirectResponse|Response
    {
        /** @var GuestbookGrant $grant */
        $grant = $request->attributes->get('guestbookGrant');
        $rawToken = (string) $request->session()->get(EnsureQrGuestbookGrant::SESSION_KEY);
        $visit = null;

        try {
            DB::transaction(function () use ($request, $grant, $rawToken, &$visit): void {
                $lockedGrant = GuestbookGrant::query()->lockForUpdate()->find($grant->id);

                if (! $lockedGrant
                    || ! $lockedGrant->isAvailable()
                    || ! hash_equals($lockedGrant->token_hash, hash('sha256', $rawToken))
                    || ! hash_equals($lockedGrant->session_hash, hash('sha256',
                        (string) $request->session()->get(EnsureQrGuestbookGrant::BINDING_KEY)))) {
                    throw new LogicException('QR guestbook grant is no longer available.');
                }

                $visit = $this->guestVisitService->store($request->validated(), 'qr');
                $lockedGrant->update(['used_at' => now()]);
            });
        } catch (LogicException) {
            $request->session()->forget([EnsureQrGuestbookGrant::SESSION_KEY, EnsureQrGuestbookGrant::BINDING_KEY]);

            return response()->view('tamu.qr-unavailable', status: 403);
        } catch (Throwable $exception) {
            if ($visit instanceof Tamu && $visit->gambar) {
                Storage::disk('local')->delete('visitor-photos/'.$visit->gambar);
            }

            report($exception);

            return back()
                ->withInput($request->except('gambar'))
                ->with('error', 'Data gagal disimpan. Silakan ambil foto dan coba lagi.');
        }

        $request->session()->forget([EnsureQrGuestbookGrant::SESSION_KEY, EnsureQrGuestbookGrant::BINDING_KEY]);

        return redirect()->route('tamu.qr.success');
    }

    public function success(): View
    {
        return view('tamu.qr-success');
    }

    private function qrTtlSeconds(): int
    {
        return max(30, (int) config('guestbook.qr_ttl_seconds', 90));
    }

    private function grantTtlMinutes(): int
    {
        return max(5, (int) config('guestbook.grant_ttl_minutes', 15));
    }
}
