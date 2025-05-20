<?php

namespace Database\Factories;

use App\Enums\Visibility;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GalleryFactory extends Factory
{
    protected $model = Gallery::class;

    public function definition(): array
    {
        $title = $this->faker->words(mt_rand(2, 5), true);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(Visibility::cases()),
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }

    public function published(): static
    {
        return $this->state(function () {
            return [
                'status' => Visibility::PUBLISHED,
            ];
        });
    }

    public function draft(): static
    {
        return $this->state(function () {
            return [
                'status' => Visibility::DRAFT,
            ];
        });
    }
}
