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

        // Get all events associated with this ranklist with eager loading
        $events = $rankList->events()->with('attendedUsers')->get();

        if ($events->isEmpty()) {
            $this->comment('No events found for this ranklist.');
            return;
        }

        // Get all users for this ranklist
        $users = $rankList->users;
        $userIds = $users->pluck('id')->toArray();
        
        // Get the weight of upsolve for this ranklist
        $weightOfUpsolve = $rankList->weight_of_upsolve;
        
        // Get all event IDs to efficiently fetch user stats in one query
        $eventIds = $events->pluck('id')->toArray();
        
        // Fetch all user solve stats for these users and events in one query
        $userStats = UserSolveStatOnEvent::whereIn('user_id', $userIds)
            ->whereIn('event_id', $eventIds)
            ->get()
            ->groupBy(function($stat) {
                return $stat->user_id . '_' . $stat->event_id;
            });
        
        // Check if ranklist considers strict attendance
        $considerStrictAttendance = $rankList->consider_strict_attendance;
        
        // Create a map for quick attendance lookup
        $attendanceMap = [];
        if ($considerStrictAttendance) {
            foreach ($events as $event) {
                if ($event->strict_attendance) {
                    foreach ($event->attendedUsers as $attendee) {
                        $attendanceMap[$attendee->id . '_' . $event->id] = true;
                    }
                }
            }
        }
        
        $userScores = [];
        
        foreach ($users as $user) {
            $totalScore = 0;

            foreach ($events as $event) {
                $eventWeight = $event->pivot->weight;
                $userStatKey = $user->id . '_' . $event->id;
                
                // Get user solve stats from our pre-fetched collection
                $userStat = $userStats->get($userStatKey) ? $userStats->get($userStatKey)->first() : null;
                
                if ($userStat) {
                    // Check attendance status only if ranklist considers strict attendance
                    $hasAttendance = !$considerStrictAttendance || 
                                    !$event->strict_attendance || 
                                    isset($attendanceMap[$user->id . '_' . $event->id]);
                    
                    if ($hasAttendance) {
                        // Regular calculation: solvecountweight + upsolvecountweight*weightofupsolve
                        $solveScore = $userStat->solve_count * $eventWeight;
                        $upsolveScore = $userStat->upsolve_count * $eventWeight * $weightOfUpsolve;
                    } else {
                        // If strict attendance is enforced and user hasn't attended, treat all solves as upsolves
                        $solveScore = 0;
                        $upsolveScore = ($userStat->solve_count + $userStat->upsolve_count) * $eventWeight * $weightOfUpsolve;
                    }

                    $eventScore = $solveScore + $upsolveScore;
                    $totalScore += $eventScore;
                }
            }
            
            $userScores[] = [
                'rank_list_id' => $rankList->id,
                'user_id' => $user->id,
                'score' => $totalScore,
            ];
        }
        
        // Batch update all scores at once
        if (!empty($userScores)) {
            foreach ($userScores as $scoreData) {
                DB::table('rank_list_user')
                    ->updateOrInsert(
                        [
                            'rank_list_id' => $scoreData['rank_list_id'],
                            'user_id' => $scoreData['user_id'],
                        ],
                        [
                            'score' => $scoreData['score'],
                        ]
                    );
            }
        }

        $this->line('Completed processing ranklist: '.$rankList->keyword);
    }
}
