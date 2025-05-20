<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 100 users with profile pictures
        User::factory()
            ->count(100)
            ->create();

        // Profile pictures are automatically added via the factory's afterCreating callback
    }
}
