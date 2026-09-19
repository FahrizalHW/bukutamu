<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_one_superadmin_from_configuration(): void
    {
        config()->set('admin', [
            'name' => 'Admin Sekolah',
            'username' => 'admin-sekolah',
            'password' => 'password-baru',
        ]);

        $this->seed(AdminSeeder::class);

        $admin = User::sole();
        $this->assertSame('Admin Sekolah', $admin->full_name);
        $this->assertSame('admin-sekolah', $admin->username);
        $this->assertSame('superadmin', $admin->role);
        $this->assertTrue(Hash::check('password-baru', $admin->password));
    }

    public function test_seeder_does_not_duplicate_or_reset_existing_superadmin(): void
    {
        $admin = User::factory()->create(['password' => 'password-pribadi']);
        config()->set('admin.password', 'password-seeder');

        $this->seed(AdminSeeder::class);

        $this->assertSame(1, User::count());
        $this->assertTrue(Hash::check('password-pribadi', $admin->fresh()->password));
    }
}
