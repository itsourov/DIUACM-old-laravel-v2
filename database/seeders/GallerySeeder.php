<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 galleries (mix of published and draft)
        $galleries = Gallery::factory()
            ->count(10)
            ->create();

        // Add images to galleries
        foreach (Gallery::all() as $gallery) {
            // Add 3-7 random images to each gallery
            $imageCount = rand(3, 7);
            
            for ($i = 0; $i < $imageCount; $i++) {
                $gallery->addMediaFromUrl('https://picsum.photos/800/600')
                    ->toMediaCollection('gallery-images', 'gallery-images');
            }
        }
    }
}
