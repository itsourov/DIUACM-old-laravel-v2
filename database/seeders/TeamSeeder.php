<?php

namespace Database\Seeders;

use App\Models\Contest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all contests and users
        $contests = Contest::all();
        $users = User::all();

        if ($users->count() < 3) {
            throw new \Exception('Need at least 3 users to create teams. Please run the UserSeeder first.');
        }

        // For each contest, create 5-10 teams
        foreach ($contests as $contest) {
            $teamCount = rand(5, 10);

            for ($i = 0; $i < $teamCount; $i++) {
                // Create a team
                $team = Team::factory()->create([
                    'contest_id' => $contest->id,
                    'rank' => $i + 1, // Assign sequential ranks
                ]);

                // Get 3 random users who aren't already in a team for this contest
                $usedUserIds = $contest->teams()
                    ->with('members')
                    ->get()
                    ->pluck('members')
                    ->flatten()
                    ->pluck('id')
                    ->toArray();

                $availableUsers = $users->whereNotIn('id', $usedUserIds);

                // If we don't have enough unique users, just get random users
                if ($availableUsers->count() < 3) {
                    $availableUsers = $users;
                }

                $teamMembers = $availableUsers->random(3);

                // Attach the 3 users to the team
                $team->members()->attach($teamMembers->pluck('id')->toArray());
            }
        }
    }
}
