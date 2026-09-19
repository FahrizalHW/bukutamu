<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('role', User::ROLE_SUPERADMIN)->exists()) {
            $this->command?->info('Akun superadmin sudah tersedia. Seeder dilewati.');
            return;
        }

        $name = trim((string) config('admin.name'));
        $username = trim((string) config('admin.username'));
        $password = (string) config('admin.password');

        if ($name === '' || $username === '' || $password === '') {
            throw new RuntimeException(
                'ADMIN_NAME, ADMIN_USERNAME, dan ADMIN_PASSWORD wajib diisi sebelum menjalankan seeder.'
            );
        }

        if (mb_strlen($password) < 8) {
            throw new RuntimeException('ADMIN_PASSWORD minimal terdiri dari 8 karakter.');
        }

        User::create([
            'full_name' => $name,
            'username' => $username,
            'password' => $password,
            'role' => User::ROLE_SUPERADMIN,
        ]);
    }
}
