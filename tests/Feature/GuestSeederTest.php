<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\GuestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GuestSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_and_keeps_one_configured_guest_account(): void
    {
        config()->set('guest', [
            'name' => 'Tamu',
            'username' => 'tamu',
            'password' => 'tamu@SMKN4',
        ]);

        $this->seed(GuestSeeder::class);

        $guest = User::where('username', 'tamu')->sole();
        $this->assertSame('Tamu', $guest->full_name);
        $this->assertSame(User::ROLE_GUEST, $guest->role);
        $this->assertTrue(Hash::check('tamu@SMKN4', $guest->password));

        $guest->update([
            'full_name' => 'Nama Lama',
            'password' => 'password-lama',
            'role' => 'operator',
        ]);

        $this->seed(GuestSeeder::class);

        $guest->refresh();
        $this->assertSame('Tamu', $guest->full_name);
        $this->assertSame(User::ROLE_GUEST, $guest->role);
        $this->assertTrue(Hash::check('tamu@SMKN4', $guest->password));
        $this->assertSame(1, User::where('username', 'tamu')->count());
    }
}
