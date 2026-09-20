<?php

namespace Tests\Feature;

use App\Models\Tamu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OperatorAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_remain_public_while_reception_and_kiosk_require_login(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Masuk Petugas')
            ->assertSee(route('login'), false);

        $this->get(route('reception.index'))->assertRedirect(route('login'));
        $this->get(route('reception.qr.index'))->assertRedirect(route('login'));
        $this->get(route('tamu.create'))->assertRedirect(route('login'));
        $this->post(route('tamu.store'), [])->assertRedirect(route('login'));
    }

    public function test_operator_login_ignores_admin_intended_url_and_redirects_to_reception(): void
    {
        $operator = User::factory()->create([
            'username' => 'operator',
            'password' => 'password-operator',
            'role' => User::ROLE_OPERATOR,
        ]);

        $this->get(route('dashboard.index'))->assertRedirect(route('login'));

        $this->post(route('login.store'), [
            'username' => 'operator',
            'password' => 'password-operator',
        ])->assertRedirect(route('reception.index'));

        $this->assertAuthenticatedAs($operator);
        $this->get(route('login'))->assertRedirect(route('reception.index'));
    }

    public function test_operator_can_run_reception_but_cannot_access_administration(): void
    {
        $operator = User::factory()->create(['role' => User::ROLE_OPERATOR]);
        $record = Tamu::create([
            'nama_tamu' => 'Tamu Terdaftar',
            'jenis_kelamin' => 'L',
            'nohp' => '081234567890',
            'asal' => 'Instansi',
            'tujuan' => 'Kunjungan',
            'gambar' => 'foto.jpg',
        ]);

        $this->actingAs($operator)->get(route('home'))->assertOk();
        $this->actingAs($operator)->get(route('reception.index'))->assertOk();
        $this->actingAs($operator)->get(route('reception.qr.index'))->assertOk();
        $this->actingAs($operator)->getJson(route('reception.qr.token'))->assertOk();
        $this->actingAs($operator)->get(route('tamu.create'))->assertOk();

        foreach ([
            route('dashboard.index'),
            route('profile.edit'),
            route('rekap.index'),
            route('rekap.data'),
            route('rekap.show', $record),
            route('rekap.edit', $record),
            route('rekap.photo', $record),
            route('rekap.export.excel'),
            route('rekap.export.pdf'),
            route('admin.qr-tamu.legacy'),
        ] as $url) {
            $this->actingAs($operator)->get($url)->assertForbidden();
        }

        $this->actingAs($operator)->patch(route('profile.update'), [])->assertForbidden();
        $this->actingAs($operator)->put(route('rekap.update', $record), [])->assertForbidden();
        $this->actingAs($operator)->delete(route('rekap.destroy', $record))->assertForbidden();
    }

    public function test_operator_navigation_and_logout_are_role_aware(): void
    {
        $operator = User::factory()->create(['role' => User::ROLE_OPERATOR]);

        $this->actingAs($operator)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Penerimaan')
            ->assertSee(route('reception.index'), false)
            ->assertDontSee('Dashboard');

        $this->actingAs($operator)
            ->get(route('reception.index'))
            ->assertOk()
            ->assertSee('Tampilkan QR Mandiri')
            ->assertSee('Isi melalui Kiosk');

        $this->actingAs($operator)
            ->get(route('tamu.create'))
            ->assertOk()
            ->assertSee('Penerimaan')
            ->assertSee('id="operator-logout-form"', false);

        $this->actingAs($operator)->post(route('logout'))->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_superadmin_can_use_reception_and_legacy_qr_url_redirects(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_SUPERADMIN]);

        $this->actingAs($admin)->get(route('reception.index'))->assertOk();
        $this->actingAs($admin)->get(route('reception.qr.index'))->assertOk();
        $this->actingAs($admin)->getJson(route('reception.qr.token'))->assertOk();
        $this->actingAs($admin)->get(route('tamu.create'))->assertOk();
        $this->actingAs($admin)
            ->get(route('admin.qr-tamu.legacy'))
            ->assertRedirect(route('reception.qr.index'));
    }

    public function test_unsupported_role_cannot_complete_login(): void
    {
        User::factory()->create([
            'username' => 'auditor',
            'password' => 'password-auditor',
            'role' => 'auditor',
        ]);

        $this->post(route('login.store'), [
            'username' => 'auditor',
            'password' => 'password-auditor',
        ])->assertRedirect(route('login'))->assertSessionHas('error');

        $this->assertGuest();
    }
}
