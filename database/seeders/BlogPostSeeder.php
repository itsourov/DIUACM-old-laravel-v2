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


        // Create 15 regular published blog posts
        $posts = BlogPost::factory()
            ->count(15)
            ->published()
            ->create();



        foreach (BlogPost::all() as $post) {

            $post->addMediaFromUrl('https://picsum.photos/400/400')
                ->toMediaCollection('post-featured-images', 'post-featured-images');;
        }
    }
}
