<?php

namespace App\Console\Commands;

use App\Models\RankList;
use App\Models\User;
use App\Models\UserSolveStatOnEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RecalculateRanklistScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:recalculate-ranklist-score';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate scores for all users in all active ranklists';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to recalculate ranklist scores...');

        // Get all active ranklists
        $rankLists = RankList::where('is_active', true)->get();

        if ($rankLists->isEmpty()) {
            $this->warn('No active ranklists found.');

            return;
        }

        $this->info('Found '.$rankLists->count().' active ranklists.');

        $bar = $this->output->createProgressBar($rankLists->count());
        $bar->start();

        foreach ($rankLists as $rankList) {
            $this->recalculateScoresForRankList($rankList);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Ranklist scores recalculation completed successfully!');
    }

    /**
     * Recalculate scores for all users in a specific ranklist
     */
    private function recalculateScoresForRankList(RankList $rankList)
    {
        $this->line('Processing ranklist: '.$rankList->keyword);

        // Get all events associated with this ranklist
        $events = $rankList->events;

        if ($events->isEmpty()) {
            $this->comment('No events found for this ranklist.');

            return;
        }

        $users = $rankList->users;

        $weightOfUpsolve = $rankList->weight_of_upsolve;

        foreach ($users as $user) {
            $totalScore = 0;

            foreach ($events as $event) {
                // Get the weight of this event for this ranklist
                $eventWeight = $event->pivot->weight;

                // Find user's solve stats for this event
                $userStat = UserSolveStatOnEvent::where('user_id', $user->id)
                    ->where('event_id', $event->id)
                    ->first();

                if ($userStat) {
                    // Calculate score based on the formula: solvecountweight + upsolvecountweight*weightofupsolve
                    $solveScore = $userStat->solve_count * $eventWeight;
                    $upsolveScore = $userStat->upsolve_count * $eventWeight * $weightOfUpsolve;

                    $eventScore = $solveScore + $upsolveScore;
                    $totalScore += $eventScore;
                }
            }

            // Update the user's score in the pivot table
            DB::table('rank_list_user')
                ->updateOrInsert(
                    [
                        'rank_list_id' => $rankList->id,
                        'user_id' => $user->id,
                    ],
                    [
                        'score' => $totalScore,
                    ]
                );
        }

        $this->line('Completed processing ranklist: '.$rankList->keyword);
    }
}
