<?php

namespace Tests\Feature;

use App\Http\Middleware\EnsureQrGuestbookGrant;
use App\Models\GuestbookGrant;
use App\Models\Tamu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class QrGuestbookTest extends TestCase
{
    use RefreshDatabase;

    private function pngDataUri(): string
    {
        $image = imagecreatetruecolor(10, 10);
        imagefill($image, 0, 0, imagecolorallocate($image, 24, 121, 78));
        ob_start();
        imagepng($image);
        $contents = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,'.base64_encode($contents);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'nama_tamu' => 'Pengunjung QR',
            'jenis_kelamin' => 'P',
            'nohp' => '081234567890',
            'asal' => 'Dinas Pendidikan',
            'tujuan' => 'Koordinasi',
            'keterangan' => null,
            'gambar' => $this->pngDataUri(),
        ], $overrides);
    }

    private function signedEntryUrl(?\DateTimeInterface $expiresAt = null): string
    {
        return URL::temporarySignedRoute(
            'tamu.qr.enter',
            $expiresAt ?? now()->addSeconds(90)
        );
    }

    public function test_operator_can_open_display_and_generate_qr_url(): void
    {
        $this->get(route('reception.qr.index'))->assertRedirect(route('login'));

        $operator = User::factory()->create(['role' => User::ROLE_OPERATOR]);

        $this->actingAs($operator)
            ->get(route('reception.qr.index'))
            ->assertOk()
            ->assertSee('QR Buku Tamu');

        $response = $this->actingAs($operator)->getJson(route('reception.qr.token'));

        $response->assertOk()
            ->assertJsonStructure(['url', 'expires_at', 'ttl_seconds'])
            ->assertJsonPath('ttl_seconds', 90);
        $this->assertStringContainsString('signature=', $response->json('url'));
        $this->assertStringContainsString('/form-tamu/qr', $response->json('url'));
    }
    public function test_valid_qr_creates_hashed_session_bound_grant_and_opens_form(): void
    {
        $this->get($this->signedEntryUrl())
            ->assertRedirect(route('tamu.qr.form'));

        $rawToken = session(EnsureQrGuestbookGrant::SESSION_KEY);
        $grant = GuestbookGrant::sole();

        $this->assertNotNull($rawToken);
        $this->assertNotSame($rawToken, $grant->token_hash);
        $this->assertSame(hash('sha256', $rawToken), $grant->token_hash);
        $this->assertSame(hash('sha256', session(EnsureQrGuestbookGrant::BINDING_KEY)), $grant->session_hash);

        $this->get(route('tamu.qr.form'))
            ->assertOk()
            ->assertSee('Form Tamu Mandiri')
            ->assertSee(route('tamu.qr.store'), false);
    }

    public function test_same_qr_can_issue_grants_for_multiple_browser_sessions(): void
    {
        $url = $this->signedEntryUrl();

        $this->get($url)->assertRedirect(route('tamu.qr.form'));
        $firstHash = GuestbookGrant::sole()->session_hash;

        $this->flushSession();
        $this->get($url)->assertRedirect(route('tamu.qr.form'));

        $this->assertDatabaseCount('guestbook_grants', 2);
        $this->assertNotSame($firstHash, GuestbookGrant::query()->latest('id')->value('session_hash'));
    }

    public function test_expired_or_unsigned_qr_is_rejected(): void
    {
        $this->get(route('tamu.qr.enter'))->assertForbidden()->assertSee('QR tidak lagi berlaku');
        $this->get($this->signedEntryUrl(now()->subSecond()))
            ->assertForbidden()
            ->assertSee('QR tidak lagi berlaku');
        $this->assertDatabaseCount('guestbook_grants', 0);
    }

    public function test_expired_or_different_session_grant_cannot_open_form(): void
    {
        $this->get($this->signedEntryUrl())->assertRedirect(route('tamu.qr.form'));
        GuestbookGrant::query()->update(['expires_at' => now()->subSecond()]);

        $this->get(route('tamu.qr.form'))->assertForbidden();

        $rawToken = 'different-session-token';
        $this->withSession([EnsureQrGuestbookGrant::SESSION_KEY => $rawToken]);
        GuestbookGrant::create([
            'token_hash' => hash('sha256', $rawToken),
            'session_hash' => hash('sha256', 'another-session-id'),
            'expires_at' => now()->addMinutes(15),
        ]);

        $this->get(route('tamu.qr.form'))->assertForbidden();
    }

    public function test_validation_error_does_not_consume_grant_then_success_consumes_it_once(): void
    {
        Storage::fake('local');
        $this->get($this->signedEntryUrl())->assertRedirect(route('tamu.qr.form'));

        $this->from(route('tamu.qr.form'))
            ->post(route('tamu.qr.store'), $this->payload(['gambar' => 'bukan-gambar']))
            ->assertRedirect(route('tamu.qr.form'))
            ->assertSessionHasErrors('gambar');

        $this->assertNull(GuestbookGrant::sole()->used_at);
        $this->assertDatabaseCount('tamu', 0);

        $this->post(route('tamu.qr.store'), $this->payload())
            ->assertRedirect(route('tamu.qr.success'));

        $visit = Tamu::sole();
        $this->assertSame('qr', $visit->sumber);
        $this->assertNotNull(GuestbookGrant::sole()->used_at);
        Storage::disk('local')->assertExists('visitor-photos/'.$visit->gambar);

        $this->post(route('tamu.qr.store'), $this->payload())->assertForbidden();
        $this->assertDatabaseCount('tamu', 1);
    }

    public function test_authenticated_kiosk_flow_records_kiosk_source(): void
    {
        Storage::fake('local');
        $operator = User::factory()->create(['role' => User::ROLE_OPERATOR]);

        $this->actingAs($operator)->post(route('tamu.store'), $this->payload())->assertRedirect(route('tamu.create'));

        $this->assertSame('kiosk', Tamu::sole()->sumber);
    }
}
