<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement([Gender::MALE, Gender::FEMALE, Gender::OTHER]);

        return [
            'name' => fake()->name($gender === Gender::FEMALE ? 'female' : 'male'),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'gender' => $gender,
            'phone' => fake()->phoneNumber(),
            'codeforces_handle' => fake()->userName(),
            'atcoder_handle' => fake()->userName(),
            'vjudge_handle' => fake()->userName(),
            'starting_semester' => fake()->randomElement(['Spring 2024', 'Summer 2024', 'Fall 2023', 'Spring 2023']),
            'department' => fake()->randomElement(['CSE', 'SWE', 'EEE', 'MCT', 'CIS', 'BBA']),
            'student_id' => fake()->numerify('##-######-#'),
            'max_cf_rating' => fake()->numberBetween(0, 2200),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            // Add a profile image using the Spatie Media Library
            $user->addMediaFromUrl('https://i.pravatar.cc/300?u='.$user->id)
                ->toMediaCollection('avatar', 'avatar');
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
