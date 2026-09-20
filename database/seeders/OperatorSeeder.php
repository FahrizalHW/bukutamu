<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class OperatorSeeder extends Seeder
{
    public function run(): void
    {
        $name = trim((string) config('operator.name'));
        $username = trim((string) config('operator.username'));
        $password = (string) config('operator.password');

        if ($name === '' || $username === '' || $password === '') {
            throw new RuntimeException(
                'OPERATOR_NAME, OPERATOR_USERNAME, dan OPERATOR_PASSWORD wajib diisi sebelum menjalankan seeder.'
            );
        }

        if (mb_strlen($password) < 8) {
            throw new RuntimeException('OPERATOR_PASSWORD minimal terdiri dari 8 karakter.');
        }

        $operator = User::query()->where('username', $username)->first()
            ?? User::query()->where('role', User::ROLE_OPERATOR)->oldest('id')->first();

        if ($operator && ! in_array($operator->role, [User::ROLE_OPERATOR, 'guest'], true)) {
            throw new RuntimeException(
                "Username {$username} sudah digunakan oleh akun dengan role lain."
            );
        }

        $attributes = [
            'full_name' => $name,
            'username' => $username,
            'password' => $password,
            'role' => User::ROLE_OPERATOR,
        ];

        $operator ? $operator->update($attributes) : User::create($attributes);
    }
}
