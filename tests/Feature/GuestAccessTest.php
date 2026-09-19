<?php

namespace Tests\Feature;

use App\Models\Tamu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_stays_public_while_guestbook_requires_login(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('tamu.create'), false)
            ->assertSee('Isi Buku Tamu');

        $this->get(route('tamu.create'))->assertRedirect(route('login'));
        $this->post(route('tamu.store'), [])->assertRedirect(route('login'));
        $this->assertDatabaseCount('tamu', 0);
    }

    public function test_guest_login_ignores_admin_intended_url_and_redirects_to_guestbook(): void
    {
        $guest = User::factory()->create([
            'username' => 'tamu',
            'password' => 'tamu@SMKN4',
            'role' => User::ROLE_GUEST,
        ]);

        $this->get(route('dashboard.index'))->assertRedirect(route('login'));

        $this->post(route('login.store'), [
            'username' => 'tamu',
            'password' => 'tamu@SMKN4',
        ])->assertRedirect(route('tamu.create'));

        $this->assertAuthenticatedAs($guest);
        $this->get(route('login'))->assertRedirect(route('tamu.create'));
    }

    public function test_guest_can_only_use_public_pages_guestbook_and_logout(): void
    {
        $guest = User::factory()->create(['role' => User::ROLE_GUEST]);
        $record = Tamu::create([
            'nama_tamu' => 'Tamu Terdaftar',
            'jenis_kelamin' => 'L',
            'nohp' => '081234567890',
            'asal' => 'Instansi',
            'tujuan' => 'Kunjungan',
            'gambar' => 'foto.jpg',
        ]);

        $this->actingAs($guest)->get(route('home'))->assertOk();
        $this->actingAs($guest)->get(route('tamu.create'))->assertOk();

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
        ] as $url) {
            $this->actingAs($guest)->get($url)->assertForbidden();
        }

        $this->actingAs($guest)
            ->patch(route('profile.update'), [])
            ->assertForbidden();
        $this->actingAs($guest)
            ->put(route('rekap.update', $record), [])
            ->assertForbidden();
        $this->actingAs($guest)
            ->delete(route('rekap.destroy', $record))
            ->assertForbidden();
    }

    public function test_navigation_and_logout_are_role_aware(): void
    {
        $guest = User::factory()->create(['role' => User::ROLE_GUEST]);
        $admin = User::factory()->create(['role' => User::ROLE_SUPERADMIN]);

        $this->actingAs($guest)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Form Tamu')
            ->assertSee(route('tamu.create'), false)
            ->assertDontSee('Dashboard');

        $this->actingAs($guest)
            ->get(route('tamu.create'))
            ->assertOk()
            ->assertSee('<a href="'.route('home').'" class="kiosk-header-link">Beranda</a>', false)
            ->assertSee('<a href="'.route('logout').'" class="kiosk-header-link"', false)
            ->assertSee('id="guest-logout-form"', false);

        $this->actingAs($guest)
            ->post(route('logout'))
            ->assertRedirect(route('home'));
        $this->assertGuest();

        $this->actingAs($admin)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertDontSee('Form Tamu');
        $this->actingAs($admin)
            ->get(route('tamu.create'))
            ->assertOk()
            ->assertDontSee('Keluar');
        $this->actingAs($admin)
            ->get(route('login'))
            ->assertRedirect(route('dashboard.index'));
    }

    public function test_unsupported_role_cannot_complete_login(): void
    {
        User::factory()->create([
            'username' => 'operator',
            'password' => 'password-operator',
            'role' => 'operator',
        ]);

        $this->post(route('login.store'), [
            'username' => 'operator',
            'password' => 'password-operator',
        ])
            ->assertRedirect(route('login'))
            ->assertSessionHas('error');

        $this->assertGuest();
    }
}
