<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'password' => 'password',
            'role' => User::ROLE_SUPERADMIN,
            'remember_token' => Str::random(10),
        ];
    }
}
