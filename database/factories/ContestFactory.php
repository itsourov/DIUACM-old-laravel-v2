<?php

namespace Database\Factories;

use App\Enums\ContestType;
use App\Models\Contest;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContestFactory extends Factory
{
    protected $model = Contest::class;

    public function definition(): array
    {
        $contestTypes = [
            ContestType::ICPC_REGIONAL,
            ContestType::ICPC_ASIA_WEST,
            ContestType::IUPC,
            ContestType::OTHER,
        ];

        $contestType = $this->faker->randomElement($contestTypes);

        // Create or get a gallery
        $gallery = Gallery::inRandomOrder()->first() ?? Gallery::factory()->create();

        return [
            'name' => match ($contestType) {
                ContestType::ICPC_REGIONAL => 'ACM ICPC Regional '.$this->faker->year(),
                ContestType::ICPC_ASIA_WEST => 'ACM ICPC Asia West '.$this->faker->year(),
                ContestType::IUPC => $this->faker->company().' IUPC '.$this->faker->year(),
                ContestType::OTHER => $this->faker->randomElement(['Codeforces Round #'.$this->faker->numberBetween(600, 900),
                    $this->faker->company().' Hackathon '.$this->faker->year(),
                    'DIU Intra University Programming Contest '.$this->faker->year()]),
            },
            'gallery_id' => $gallery->id,
            'contest_type' => $contestType,
            'location' => $this->faker->city().', '.$this->faker->country(),
            'date' => $this->faker->dateTimeBetween('-2 years', '+6 months'),
            'description' => $this->faker->paragraphs(3, true),
            'standings_url' => $this->faker->url(),
        ];
    }
}
