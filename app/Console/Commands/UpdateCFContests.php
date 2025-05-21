<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\User;
use App\Models\UserSolveStatOnEvent;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateCFContests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-cf-contests
                           {--limit= : Limit the number of contests to process}
                           {--id= : Process a specific contest/event by ID}
                           {--fresh : Clear existing stats before updating}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates solve statistics for Codeforces contests by calculating contest solves and upsolves for each user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting Codeforces Contest Statistics Update');

        // Handle fresh option - clear existing stats if requested
        if ($this->option('fresh')) {
            if ($this->confirm('This will delete all existing Codeforces solve statistics. Continue?', false)) {
                $this->info('Clearing existing statistics...');
                UserSolveStatOnEvent::truncate();
                $this->info('Existing statistics cleared.');
            } else {
                $this->info('Operation cancelled.');

                return 1;
            }
        }

        // Build query for events with CodeForces links
        $query = Event::where('event_link', 'like', '%codeforces.com%')
            ->whereHas('rankLists', function ($query) {
                $query->where('is_active', true);
            });

        // Filter by specific event ID if provided
        if ($this->option('id')) {
            $query->where('id', $this->option('id'));
        }

        // Get the events
        $events = $query->get(['id', 'title', 'starting_at', 'event_link']);

        // Apply limit if provided
        if ($this->option('limit') && is_numeric($this->option('limit'))) {
            $limit = (int) $this->option('limit');
            $events = $events->take($limit);
        }

        if ($events->isEmpty()) {
            $this->info('No Codeforces contests found to process');

            return 0;
        }

        $this->info("Found {$events->count()} Codeforces contests to process");

        $processedCount = 0;
        $successCount = 0;
        $failedCount = 0;
        $skippedCount = 0;
        $results = [];

        $startTime = now();

        // Create progress bar for better visual feedback
        $progressBar = $this->output->createProgressBar($events->count());
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s% | %message%');
        $progressBar->setMessage('Starting...');
        $progressBar->start();

        // Process each event
        foreach ($events as $index => $event) {
            $processedCount++;
            $progressBar->setMessage("Processing: {$event->title}");
            $progressBar->advance();

            // Extract contest ID from event link
            $contestId = $this->extractContestId($event->event_link);
            if (! $contestId) {
                $progressBar->setMessage("<fg=red>Invalid URL: {$event->event_link}</>");
                $this->newLine(2);
                $this->warn("Invalid contest URL: {$event->event_link}");
                $failedCount++;
                $results[] = [
                    'eventId' => $event->id,
                    'title' => $event->title,
                    'status' => 'failed',
                    'reason' => 'invalid-url',
                ];

                continue;
            }

            // Create a progress indicator string
            $progress = ($index + 1).'/'.$events->count();

            // Process the contest
            $result = $this->processSingleCodeforcesContest($event, $contestId, $progress);

            $results[] = [
                'eventId' => $event->id,
                'title' => $event->title,
                'status' => $result['status'] ?? 'failed',
                'reason' => $result['reason'] ?? null,
                'message' => $result['message'] ?? null,
                'usersProcessed' => $result['usersProcessed'] ?? 0,
                'totalSolves' => $result['totalSolves'] ?? 0,
                'totalUpsolves' => $result['totalUpsolves'] ?? 0,
            ];

            // Update counters
            if (isset($result['status']) && $result['status'] === 'success') {
                $successCount++;
                $progressBar->setMessage("<fg=green>Completed: {$event->title}</>");
            } elseif (isset($result['status']) && $result['status'] === 'skipped') {
                $skippedCount++;
                $progressBar->setMessage("<fg=yellow>Skipped: {$event->title}</>");
            } else {
                $failedCount++;
                $progressBar->setMessage("<fg=red>Failed: {$event->title}</>");
            }
        }

        // Finish the progress bar
        $progressBar->finish();
        $this->newLine(2);

        $duration = now()->diffInSeconds($startTime);

        // Collect any error messages for failed contests
        $failedContests = collect($results)->filter(function ($result) {
            return $result['status'] === 'failed';
        });

        // Log final summary
        $this->newLine();
        $this->info('📈 Codeforces Contest Statistics Update Complete');
        $this->table(
            ['Metric', 'Value'],
            [
                ['Duration', "{$duration}s"],
                ['Total Events', $events->count()],
                ['Successful', "<fg=green>{$successCount}</>"],
                ['Failed', $failedCount > 0 ? "<fg=red>{$failedCount}</>" : "<fg=green>{$failedCount}</>"],
                ['Skipped', $skippedCount > 0 ? "<fg=yellow>{$skippedCount}</>" : "<fg=green>{$skippedCount}</>"],
            ]
        );

        // Calculate overall statistics
        $totalUsers = collect($results)->sum('usersProcessed');
        $totalSolves = collect($results)->sum('totalSolves');
        $totalUpsolves = collect($results)->sum('totalUpsolves');

        // Display overall statistics if there were successful updates
        if ($successCount > 0) {
            $this->newLine();
            $this->info('📊 Overall Statistics:');
            $this->table(
                ['Metric', 'Count'],
                [
                    ['Total Users Processed', $totalUsers],
                    ['Total Contest Solves', $totalSolves],
                    ['Total Contest Upsolves', $totalUpsolves],
                    ['Total Problem Solves', $totalSolves + $totalUpsolves],
                ]
            );
        }

        // If there were failures, display additional information
        if ($failedCount > 0) {
            $this->newLine();
            $this->warn('⚠️ Failed Contests:');

            $failedRows = [];
            foreach ($failedContests as $contest) {
                $failedRows[] = [
                    $contest['eventId'],
                    $contest['title'],
                    $contest['reason'] ?? 'unknown',
                    $contest['message'] ?? 'No details available',
                ];
            }

            $this->table(
                ['Event ID', 'Title', 'Reason', 'Message'],
                $failedRows
            );

            $this->line('<fg=yellow>To retry a specific failed contest, use:</>');
            $this->line('<fg=yellow>php artisan app:update-cf-contests --id=[EVENT_ID]</>');
        }

        // Add a recommendation for future runs
        if ($events->count() > 5) {
            $this->newLine();
            $this->line('<fg=blue>💡 Tip: For faster processing, you can process contests in smaller batches:</>');
            $this->line('<fg=blue>   php artisan app:update-cf-contests --limit=5</>');
        }

        return 0;
    }

    /**
     * Extract contest ID from a Codeforces URL
     */
    private function extractContestId(?string $eventLink): ?string
    {
        if (! $eventLink) {
            return null;
        }

        $match = preg_match('/contests\/(\d+)/', $eventLink, $matches);

        return $match ? $matches[1] : null;
    }

    /**
     * Process a single Codeforces contest
     */
    private function processSingleCodeforcesContest(Event $event, string $contestId, string $progress): array
    {
        $this->info("📊 Processing contest {$progress}: {$event->title} (ID: {$contestId})");

        try {
            // Find all users with CF handles in the ranklists associated with this event
            $usersWithHandles = User::whereNotNull('codeforces_handle')
                ->whereHas('rankLists', function ($query) use ($event) {
                    $query->whereHas('events', function ($subQuery) use ($event) {
                        $subQuery->where('events.id', $event->id);
                    });
                })
                ->select(['id', 'codeforces_handle'])
                ->get();

            if ($usersWithHandles->isEmpty()) {
                $this->warn("No users found with CF handles for event: {$event->title}");

                return ['status' => 'skipped', 'reason' => 'no-users'];
            }

            $this->info("Found {$usersWithHandles->count()} users to process");

            // Fetch data from Codeforces API
            $contestResult = $this->fetchCodeforcesStandings($contestId, $usersWithHandles);

            if (! $contestResult['success']) {
                $this->error('❌ Failed to fetch contest data from Codeforces API');
                $this->line("<fg=red>Error: {$contestResult['error']}</>");
                $this->line('<fg=yellow>This could be due to API rate limits, network issues, or invalid contest ID.</>');
                $this->line("<fg=yellow>Try again later or check if contest ID {$contestId} exists on Codeforces.</>");

                Log::warning('Codeforces API fetch failed for contest', [
                    'contestId' => $contestId,
                    'eventId' => $event->id,
                    'error' => $contestResult['error'],
                ]);

                return [
                    'status' => 'failed',
                    'reason' => 'api-error',
                    'message' => $contestResult['error'],
                ];
            }

            // Process the data and update the database
            $stats = $this->processContestResults($event->id, $usersWithHandles, $contestResult['data']);
            $this->updateSolveStatsInDatabase($stats);

            $this->info('✅ Completed processing contest');
            $this->line("Contest: {$event->title}");
            $this->line("Users: {$usersWithHandles->count()}");
            $this->line("Total Solves: {$stats['totalSolves']}");
            $this->line("Total Upsolves: {$stats['totalUpsolves']}");

            return [
                'status' => 'success',
                'usersProcessed' => $usersWithHandles->count(),
                'totalSolves' => $stats['totalSolves'],
                'totalUpsolves' => $stats['totalUpsolves'],
            ];
        } catch (Exception $error) {
            $errorMessage = $error->getMessage();
            $this->error("Failed to process contest: {$errorMessage}");
            Log::error("Failed to process contest: {$errorMessage}", [
                'contestId' => $contestId,
                'eventTitle' => $event->title,
                'error' => $errorMessage,
            ]);

            return ['status' => 'failed', 'reason' => 'exception', 'message' => $errorMessage];
        }
    }

    /**
     * Fetch contest standings from Codeforces API
     */
    private function fetchCodeforcesStandings(
        string $contestId,
        $users
    ): array {
        $handles = $users->pluck('codeforces_handle')->join(';');

        $this->info('Fetching data from Codeforces API');
        $this->line("<fg=gray>API URL: https://codeforces.com/api/contest.standings (Contest ID: {$contestId})</>");

        try {
            $url = "https://codeforces.com/api/contest.standings?contestId={$contestId}&showUnofficial=true&handles=".urlencode($handles);
            $this->line("<fg=gray>Processing {$users->count()} handles...</>");

            $response = Http::timeout(30)
                ->acceptJson()
                ->withHeaders(['Connection' => 'keep-alive'])
                ->get($url);

            if (! $response->successful()) {
                $this->error("⚠️ API request failed with status code: {$response->status()}");
                $this->error("Error details: {$response->reason()}");

                // Parse the JSON body if possible to provide better error details
                $responseBody = $response->body();
                $parsedBody = json_decode($responseBody, true);
                if (json_last_error() === JSON_ERROR_NONE && isset($parsedBody['comment'])) {
                    $this->error("API error message: {$parsedBody['comment']}");

                    // Handle common error scenarios with helpful suggestions
                    if (strpos($parsedBody['comment'], 'handle') !== false) {
                        $this->line('<fg=yellow>➤ Some user handles may be invalid or no longer exist on Codeforces.</>');
                        $this->line('<fg=yellow>➤ Consider updating user profiles to remove invalid handles.</>');
                    } elseif (strpos($parsedBody['comment'], 'contestId') !== false) {
                        $this->line("<fg=yellow>➤ The contest ID {$contestId} may be invalid or not publicly accessible.</>");
                    } elseif (strpos($parsedBody['comment'], 'limit') !== false) {
                        $this->line('<fg=yellow>➤ You may have hit API rate limits. Try again in a few minutes.</>');
                    }
                } else {
                    $this->line('<fg=yellow>Response body: '.substr($responseBody, 0, 200).(strlen($responseBody) > 200 ? '...' : '').'</>');
                }

                Log::error('Codeforces API request failed', [
                    'contestId' => $contestId,
                    'status' => $response->status(),
                    'reason' => $response->reason(),
                    'response' => substr($response->body(), 0, 500),
                ]);

                return [
                    'success' => false,
                    'error' => "API request failed: {$response->status()} {$response->reason()}",
                ];
            }

            $data = $response->json();

            if (! isset($data['status']) || $data['status'] !== 'OK') {
                $errorMessage = 'Codeforces API returned error status: '.($data['status'] ?? 'Unknown');
                $errorComment = isset($data['comment']) ? "Comment: {$data['comment']}" : 'No additional details provided';

                $this->error("⚠️ {$errorMessage}");
                $this->error($errorComment);

                Log::error('Codeforces API error response', [
                    'contestId' => $contestId,
                    'status' => $data['status'] ?? 'Unknown',
                    'comment' => $data['comment'] ?? null,
                ]);

                return [
                    'success' => false,
                    'error' => $errorMessage.'. '.$errorComment,
                ];
            }

            $this->info('Successfully retrieved contest data from Codeforces');
            $this->line("Contest name: <fg=green>{$data['result']['contest']['name']}</>");
            $this->line('Problem count: <fg=green>'.count($data['result']['problems']).'</>');
            $this->line('Participant rows: <fg=green>'.count($data['result']['rows']).'</>');

            return ['success' => true, 'data' => $data];
        } catch (Exception $error) {
            $errorMessage = $error->getMessage();
            $this->error("⚠️ Exception during API request: {$errorMessage}");
            $this->line('<fg=red>Stack trace: '.substr($error->getTraceAsString(), 0, 200).'...</>');

            Log::error('Exception during Codeforces API request', [
                'contestId' => $contestId,
                'message' => $errorMessage,
                'trace' => $error->getTraceAsString(),
            ]);

            return ['success' => false, 'error' => "Error fetching contest data: {$errorMessage}"];
        }
    }

    /**
     * Process contest results and prepare stats
     */
    private function processContestResults(
        int $eventId,
        $users,
        array $data
    ): array {
        $solveStats = [];
        $rows = $data['result']['rows'];

        $this->info("Processing statistics for {$users->count()} users");

        $totalSolves = 0;
        $totalUpsolves = 0;
        $userStats = [];

        foreach ($users as $user) {
            // Find rows for this user - both contest participation and practice
            $contestRow = collect($rows)->first(function ($row) use ($user) {
                return isset($row['party']['members'][0]['handle']) &&
                    strtolower($row['party']['members'][0]['handle']) === strtolower($user->codeforces_handle) &&
                    in_array($row['party']['participantType'], ['CONTESTANT', 'OUT_OF_COMPETITION']);
            });

            $practiceRow = collect($rows)->first(function ($row) use ($user) {
                return isset($row['party']['members'][0]['handle']) &&
                    strtolower($row['party']['members'][0]['handle']) === strtolower($user->codeforces_handle) &&
                    $row['party']['participantType'] === 'PRACTICE';
            });

            $stats = $this->calculateUserStats($contestRow, $practiceRow);

            $totalSolves += $stats['solve_count'];
            $totalUpsolves += $stats['upsolve_count'];

            $solveStats[] = [
                'userId' => $user->id,
                'eventId' => $eventId,
                'solveCount' => $stats['solve_count'],
                'upsolveCount' => $stats['upsolve_count'],
                'participation' => ! is_null($contestRow),
            ];

            // Add to user stats for logging
            $userStats[] = [
                'handle' => $user->codeforces_handle,
                'solves' => $stats['solve_count'],
                'upsolves' => $stats['upsolve_count'],
                'total' => $stats['solve_count'] + $stats['upsolve_count'],
                'participationType' => $contestRow ? $contestRow['party']['participantType'] : 'No',
            ];
        }

        // Log summary - only include top performers
        $topUsers = collect($userStats)
            ->sortByDesc(function ($user) {
                return $user['solves'] + $user['upsolves'];
            })
            ->take(3)
            ->values()
            ->all();

        $this->info('Processed statistics');
        $this->line("Total users: {$users->count()}");
        $this->line("Total solves: {$totalSolves}");
        $this->line("Total upsolves: {$totalUpsolves}");
        $this->line('Total problems solved: '.($totalSolves + $totalUpsolves));

        $this->line('Top performers:');
        foreach ($topUsers as $index => $user) {
            $this->line('  '.($index + 1).". {$user['handle']}: {$user['total']} ({$user['solves']} solved, {$user['upsolves']} upsolved)");
        }

        return [
            'solveStats' => $solveStats,
            'totalSolves' => $totalSolves,
            'totalUpsolves' => $totalUpsolves,
            'userStats' => $userStats,
        ];
    }

    /**
     * Calculate detailed stats for a user
     */
    private function calculateUserStats(
        $contestRow,
        $practiceRow
    ): array {
        $solveCount = 0;
        $contestSolvedProblems = [];

        if ($contestRow) {
            foreach ($contestRow['problemResults'] as $index => $problem) {
                if (isset($problem['points']) && $problem['points'] > 0) {
                    $solveCount++;
                    $contestSolvedProblems[] = $index;
                }
            }
        }

        $upsolveCount = 0;
        if ($practiceRow) {
            foreach ($practiceRow['problemResults'] as $index => $problem) {
                if (isset($problem['points']) && $problem['points'] > 0 && ! in_array($index, $contestSolvedProblems)) {
                    $upsolveCount++;
                }
            }
        }

        return [
            'solve_count' => $solveCount,
            'upsolve_count' => $upsolveCount,
        ];
    }

    /**
     * Update solve stats in the database
     */
    private function updateSolveStatsInDatabase(
        array $stats
    ): void {
        $this->info('Updating database records for '.count($stats['solveStats']).' users');

        // Process in chunks to avoid overwhelming the database
        $chunkSize = 100;
        $chunks = array_chunk($stats['solveStats'], $chunkSize);

        foreach ($chunks as $i => $chunk) {
            $this->line('Processing database batch '.($i + 1).'/'.count($chunks));

            // Create or update solve stats for each user
            foreach ($chunk as $stat) {
                UserSolveStatOnEvent::updateOrCreate(
                    [
                        'user_id' => $stat['userId'],
                        'event_id' => $stat['eventId'],
                    ],
                    [
                        'solve_count' => $stat['solveCount'],
                        'upsolve_count' => $stat['upsolveCount'],
                        'participation' => $stat['participation'],
                    ]
                );
            }
        }
    }
}
