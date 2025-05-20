<?php

namespace Database\Factories;

use App\Models\Contest;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        $teamPrefixes = [
            'Code', 'Byte', 'Algorithm', 'Binary', 'Data',
            'Error', 'Function', 'Glitch', 'Hash', 'Integer',
            'Java', 'Kernel', 'Logic', 'Memory', 'Null',
            'Object', 'Python', 'Query', 'Runtime', 'Stack',
            'Thread', 'Unix', 'Virtual', 'Web', 'XML',
        ];

        $teamSuffixes = [
            'Breakers', 'Bandits', 'Avengers', 'Bosses', 'Demons',
            'Eliminators', 'Fanatics', 'Guardians', 'Heroes', 'Innovators',
            'Jedi', 'Kings', 'Lords', 'Masters', 'Navigators',
            'Oriented', 'Panthers', 'Questers', 'Rangers', 'Smashers',
            'Thrashers', 'Unicorns', 'Vanguards', 'Wizards', 'Xperts',
        ];

        return [
            'name' => $this->faker->randomElement($teamPrefixes).' '.
                      $this->faker->randomElement($teamSuffixes).' '.
                      $this->faker->unique()->numberBetween(1, 10000),
            'contest_id' => Contest::factory(),
            'rank' => $this->faker->numberBetween(1, 100),
            'solveCount' => $this->faker->numberBetween(0, 12),
        ];
    }
}
