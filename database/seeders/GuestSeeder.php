<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/** @deprecated Use OperatorSeeder. Kept for one deployment transition. */
class GuestSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(OperatorSeeder::class);
    }
}
