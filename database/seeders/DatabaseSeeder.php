<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test/admin user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            // Seed regular users
            UserSeeder::class,

            // Seed galleries and blog posts
            GallerySeeder::class,
            BlogPostSeeder::class,

            // Seed contests and teams
            ContestSeeder::class,
            TeamSeeder::class,
        ]);
    }
}
