<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\OperatorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class OperatorSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_operator_config_prioritizes_new_environment_names_and_supports_legacy_fallback(): void
    {
        $repository = Env::getRepository();
        $keys = [
            'OPERATOR_NAME', 'OPERATOR_USERNAME', 'OPERATOR_PASSWORD',
            'GUEST_NAME', 'GUEST_USERNAME', 'GUEST_PASSWORD',
        ];

        foreach ($keys as $key) {
            $repository->clear($key);
        }

        try {
            $repository->set('GUEST_NAME', 'Petugas Lama');
            $repository->set('GUEST_USERNAME', 'tamu');
            $repository->set('GUEST_PASSWORD', 'password-lama');
            $legacy = require config_path('operator.php');

            $this->assertSame('Petugas Lama', $legacy['name']);
            $this->assertSame('tamu', $legacy['username']);
            $this->assertSame('password-lama', $legacy['password']);

            $repository->set('OPERATOR_NAME', 'Operator Baru');
            $repository->set('OPERATOR_USERNAME', 'operator');
            $repository->set('OPERATOR_PASSWORD', 'password-baru');
            $preferred = require config_path('operator.php');

            $this->assertSame('Operator Baru', $preferred['name']);
            $this->assertSame('operator', $preferred['username']);
            $this->assertSame('password-baru', $preferred['password']);
        } finally {
            foreach ($keys as $key) {
                $repository->clear($key);
            }
        }
    }

    public function test_seeder_creates_and_updates_one_configured_operator_account(): void
    {
        config()->set('operator', [
            'name' => 'Operator Penerimaan',
            'username' => 'operator',
            'password' => 'operator@SMKN4',
        ]);

        $this->seed(OperatorSeeder::class);

        $operator = User::where('username', 'operator')->sole();
        $this->assertSame('Operator Penerimaan', $operator->full_name);
        $this->assertSame(User::ROLE_OPERATOR, $operator->role);
        $this->assertTrue(Hash::check('operator@SMKN4', $operator->password));

        config()->set('operator', [
            'name' => 'Operator Baru',
            'username' => 'petugas',
            'password' => 'password-baru',
        ]);

        $this->seed(OperatorSeeder::class);

        $operator->refresh();
        $this->assertSame('Operator Baru', $operator->full_name);
        $this->assertSame('petugas', $operator->username);
        $this->assertSame(User::ROLE_OPERATOR, $operator->role);
        $this->assertTrue(Hash::check('password-baru', $operator->password));
        $this->assertSame(1, User::where('role', User::ROLE_OPERATOR)->count());
    }

    public function test_seeder_refuses_to_replace_an_account_with_another_role(): void
    {
        User::factory()->create([
            'username' => 'admin',
            'role' => User::ROLE_SUPERADMIN,
        ]);
        config()->set('operator', [
            'name' => 'Operator',
            'username' => 'admin',
            'password' => 'password-operator',
        ]);

        $this->expectException(\RuntimeException::class);
        $this->seed(OperatorSeeder::class);
    }

    public function test_role_migration_preserves_legacy_guest_account_and_password(): void
    {
        $legacy = User::factory()->create([
            'username' => 'tamu',
            'password' => 'password-lama',
            'role' => 'guest',
        ]);
        $passwordHash = $legacy->password;
        $migration = require database_path('migrations/2026_09_20_010000_migrate_guest_role_to_operator.php');

        $migration->up();

        $legacy->refresh();
        $this->assertSame(User::ROLE_OPERATOR, $legacy->role);
        $this->assertSame($passwordHash, $legacy->password);
        $this->assertSame('tamu', $legacy->username);
    }
}
