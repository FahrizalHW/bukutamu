<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class GuestSeeder extends Seeder
{
    public function run(): void
    {
        $name = trim((string) config('guest.name'));
        $username = trim((string) config('guest.username'));
        $password = (string) config('guest.password');

        if ($name === '' || $username === '' || $password === '') {
            throw new RuntimeException(
                'GUEST_NAME, GUEST_USERNAME, dan GUEST_PASSWORD wajib diisi sebelum menjalankan seeder.'
            );
        }

        if (mb_strlen($password) < 8) {
            throw new RuntimeException('GUEST_PASSWORD minimal terdiri dari 8 karakter.');
        }

        User::updateOrCreate(
            ['username' => $username],
            [
                'full_name' => $name,
                'password' => $password,
                'role' => User::ROLE_GUEST,
            ]
        );
    }
}
