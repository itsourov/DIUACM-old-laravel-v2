<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 featured and published blog posts
        BlogPost::factory()
            ->count(5)
            ->featured()
            ->published()
            ->create();

        // Create 15 regular published blog posts
        BlogPost::factory()
            ->count(15)
            ->published()
            ->create();

        // Create 5 draft blog posts
        BlogPost::factory()
            ->count(5)
            ->draft()
            ->create();
    }
}
