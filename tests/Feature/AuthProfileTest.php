<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_logout_and_registration_surface(): void
    {
        $admin = User::factory()->create([
            'username' => 'admin',
            'password' => 'password123',
        ]);

        $this->post(route('login.store'), [
            'username' => 'admin',
            'password' => 'password123',
        ])->assertRedirect(route('rekap.index'));

        $this->assertAuthenticatedAs($admin);

        $this->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
        $this->get('/auth/register')->assertNotFound();
        $this->post('/auth/register')->assertNotFound();
    }

    public function test_admin_pages_require_superadmin(): void
    {
        $this->get(route('rekap.index'))->assertRedirect(route('login'));
        $this->get(route('profile.edit'))->assertRedirect(route('login'));

        $operator = User::factory()->create(['role' => 'operator']);
        $this->actingAs($operator)->get(route('rekap.index'))->assertForbidden();
    }

    public function test_profile_updates_name_and_username_without_changing_blank_password(): void
    {
        $admin = User::factory()->create([
            'username' => 'admin-lama',
            'password' => 'password-lama',
        ]);
        $oldHash = $admin->password;

        $this->actingAs($admin)
            ->patch(route('profile.update'), [
                'full_name' => 'Admin Baru',
                'username' => 'admin-baru',
                'password' => '',
                'password_confirmation' => '',
            ])
            ->assertRedirect(route('profile.edit'));

        $admin->refresh();
        $this->assertSame('Admin Baru', $admin->full_name);
        $this->assertSame('admin-baru', $admin->username);
        $this->assertSame($oldHash, $admin->password);
    }

    public function test_profile_updates_password_without_old_password(): void
    {
        $admin = User::factory()->create(['password' => 'password-lama']);

        $this->actingAs($admin)
            ->patch(route('profile.update'), [
                'full_name' => $admin->full_name,
                'username' => $admin->username,
                'password' => 'password-baru',
                'password_confirmation' => 'password-baru',
            ])
            ->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('password-baru', $admin->fresh()->password));
    }

    public function test_profile_rejects_mismatched_password_and_duplicate_username(): void
    {
        $admin = User::factory()->create();
        $other = User::factory()->create();

        $this->actingAs($admin)
            ->from(route('profile.edit'))
            ->patch(route('profile.update'), [
                'full_name' => 'Admin',
                'username' => $other->username,
                'password' => 'password-baru',
                'password_confirmation' => 'berbeda',
            ])
            ->assertRedirect(route('profile.edit'))
            ->assertSessionHasErrors(['username', 'password']);
    }

    public function test_account_menu_uses_initials_and_links_identity_to_profile(): void
    {
        $admin = User::factory()->create([
            'full_name' => 'Admin Digital',
            'username' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('rekap.index'))
            ->assertOk()
            ->assertSee('<span class="user-initials" aria-hidden="true">AD</span>', false)
            ->assertSee('Admin Digital')
            ->assertSee(route('profile.edit'), false)
            ->assertSee('Keluar')
            ->assertDontSee('Superadmin')
            ->assertDontSee('user-1.jpg');

        $admin->update(['full_name' => null, 'username' => 'operator']);

        $this->actingAs($admin->fresh())
            ->get(route('rekap.index'))
            ->assertOk()
            ->assertSee('<span class="user-initials" aria-hidden="true">O</span>', false)
            ->assertSee('operator');
    }}
