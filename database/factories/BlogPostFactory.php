<?php

namespace Database\Factories;

use App\Enums\Visibility;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(mt_rand(3, 7));
        $isPublished = $this->faker->boolean(80);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'author' => $this->faker->name(),
            'content' => $this->faker->paragraphs(mt_rand(3, 7), true),
            'status' => $isPublished ? Visibility::PUBLISHED : Visibility::DRAFT,
            'published_at' => $isPublished ? $this->faker->dateTimeBetween('-1 year', 'now') : null,
            'is_featured' => $this->faker->boolean(20),
        ];
    }

    public function featured(): static
    {
        return $this->state(function () {
            return [
                'is_featured' => true,
            ];
        });
    }

    public function published(): static
    {
        return $this->state(function () {
            return [
                'status' => Visibility::PUBLISHED,
                'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            ];
        });
    }

    public function draft(): static
    {
        return $this->state(function () {
            return [
                'status' => Visibility::DRAFT,
                'published_at' => null,
            ];
        });
    }
}
