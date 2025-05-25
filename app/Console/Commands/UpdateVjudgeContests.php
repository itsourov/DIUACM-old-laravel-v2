<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\RankList;
use App\Models\UserSolveStatOnEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use DateTime;
use DateTimeZone;
use Exception;

class UpdateVjudgeContests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-vjudge-contests
                          {--cookie= : Vjudge cookie for authentication}
                          {--id= : Process a specific contest/event by ID}
                          {--limit= : Limit the number of contests to process}
                          {--fresh : Clear existing stats before updating}
                          {--no-interactive : Run without interactive prompts}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates solve statistics for Vjudge contests';

    /**
     * Vjudge API endpoints
     */
    private const VJUDGE_API = [
        'BASE_URL' => 'https://vjudge.net',
        'ENDPOINTS' => [
            'USER_UPDATE' => '/user/update',
            'CONTEST_RANK' => '/contest/rank/single'
        ]
    ];

    /**
     * Cookie cache configuration
     */
    private const CACHE_KEY = 'vjudge_cookie';
    private const CACHE_TTL = 86400; // 24 hours

    /**
     * Statistics variables
     */
    private int $totalProcessed = 0;
    private int $totalEvents = 0;
    private int $successfulUpdates = 0;
    private int $failedUpdates = 0;
    private int $skippedUpdates = 0;
    private ?string $cookie = null;
    private ?string $authenticatedUsername = null;
    private DateTime $startTime;
    private array $results = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->startTime = new DateTime('now', new DateTimeZone('UTC'));
        
        $this->info('🚀 Starting Vjudge Contests Statistics Update');
        
        // Handle fresh option - clear existing stats if requested
        if ($this->option('fresh')) {
            if ($this->confirm('This will delete all existing Vjudge solve statistics. Continue?', false)) {
                $this->info('Clearing existing statistics...');
                UserSolveStatOnEvent::where('event_id', function ($query) {
                    $query->select('id')
                          ->from('events')
                          ->whereRaw('event_link LIKE ?', ['%vjudge.net%']);
                })->delete();
                $this->info('Existing statistics cleared.');
            } else {
                $this->info('Operation cancelled.');
                return 1;
            }
        }
        
        // Handle authentication
        if (!$this->handleAuthentication()) {
            return 1;
        }

        // Build query for events with Vjudge links
        $query = Event::where('event_link', 'like', '%vjudge.net%')
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
            $this->info('No Vjudge contests found to process');
            return 0;
        }

        $this->info("Found {$events->count()} Vjudge contests to process");
        $this->totalEvents = $events->count();

        $processedCount = 0;
        $successCount = 0;
        $failedCount = 0;
        $skippedCount = 0;

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
            if (!$contestId) {
                $progressBar->setMessage("<fg=red>Invalid URL: {$event->event_link}</>");
                $this->newLine(2);
                $this->warn("Invalid contest URL: {$event->event_link}");
                $failedCount++;
                $this->results[] = [
                    'eventId' => $event->id,
                    'title' => $event->title,
                    'status' => 'failed',
                    'reason' => 'Invalid contest URL'
                ];
                continue;
            }

            // Create a progress indicator string
            $progress = ($index + 1).'/'.$events->count();

            // Process the contest
            $result = $this->processSingleVjudgeContest($event, $contestId, $progress);

            $this->results[] = [
                'eventId' => $event->id,
                'title' => $event->title,
                'status' => $result['status'] ?? 'failed',
                'usersProcessed' => $result['usersProcessed'] ?? 0,
                'totalSolves' => $result['totalSolves'] ?? 0,
                'totalUpsolves' => $result['totalUpsolves'] ?? 0,
            ];

            // Update counters
            if (isset($result['status']) && $result['status'] === 'success') {
                $successCount++;
                $this->successfulUpdates++;
                $progressBar->setMessage("<fg=green>Completed: {$event->title}</>");
            } elseif (isset($result['status']) && $result['status'] === 'skipped') {
                $skippedCount++;
                $this->skippedUpdates++;
                $progressBar->setMessage("<fg=yellow>Skipped: {$event->title}</>");
            } else {
                $failedCount++;
                $this->failedUpdates++;
                $progressBar->setMessage("<fg=red>Failed: {$event->title}</>");
            }
        }

        // Finish the progress bar
        $progressBar->finish();
        $this->newLine(2);

        $duration = now()->diffInSeconds($startTime);

        $this->displaySummary($successCount, $failedCount, $skippedCount, $events, $duration);

        return 0;
    }

    /**
     * Handle Vjudge authentication
     */
    private function handleAuthentication(): bool
    {
        $noInteractive = $this->option('no-interactive');
        $this->cookie = $this->option('cookie');

        // If running non-interactively, use provided cookie or proceed without auth
        if ($noInteractive) {
            if ($this->cookie) {
                $validationResult = $this->validateCookie($this->cookie);
                if ($validationResult['success']) {
                    $this->authenticatedUsername = $validationResult['username'];
                    $this->info("✓ Authenticated as: {$this->authenticatedUsername}");
                } else {
                    $this->warn("Invalid cookie provided, proceeding without authentication");
                    $this->cookie = null;
                }
            }
            return true;
        }

        // Try to get cached cookie if none provided
        if (!$this->cookie) {
            $this->cookie = Cache::get(self::CACHE_KEY);
        }

        // Validate existing cookie if available
        if ($this->cookie) {
            $validationResult = $this->validateCookie($this->cookie);
            if ($validationResult['success']) {
                $this->authenticatedUsername = $validationResult['username'];
                if (!$this->confirm("Currently authenticated as {$this->authenticatedUsername}. Continue with this session?")) {
                    $this->cookie = null;
                    Cache::forget(self::CACHE_KEY);
                }
            } else {
                $this->warn("Cached cookie is invalid");
                $this->cookie = null;
                Cache::forget(self::CACHE_KEY);
            }
        }

        // If no valid cookie, ask for new one
        if (!$this->cookie) {
            if ($this->confirm('Would you like to authenticate with Vjudge?', true)) {
                $attempts = 0;
                $maxAttempts = 3;

                while ($attempts < $maxAttempts) {
                    $this->cookie = $this->ask('Please enter your Vjudge cookie (entire cookie string):');
                    if ($this->cookie) {
                        $this->cookie = trim($this->cookie, '"\''); // Remove quotes if present
                    }
                    
                    $validationResult = $this->validateCookie($this->cookie);

                    if ($validationResult['success']) {
                        $this->authenticatedUsername = $validationResult['username'];
                        $this->info("✓ Successfully authenticated as: {$this->authenticatedUsername}");

                        // Cache the successful cookie
                        if ($this->confirm('Would you like to remember this cookie for 24 hours?', true)) {
                            Cache::put(self::CACHE_KEY, $this->cookie, self::CACHE_TTL);
                            $this->info('Cookie cached successfully');
                        }

                        break;
                    }

                    $attempts++;
                    if ($attempts < $maxAttempts) {
                        $this->error("Invalid cookie. Please try again ({$attempts}/{$maxAttempts})");
                    } else {
                        $this->error("Maximum authentication attempts reached");
                        if (!$this->confirm('Would you like to continue without authentication?', true)) {
                            return false;
                        }
                        $this->cookie = null;
                    }
                }
            } else {
                $this->warn("Proceeding without authentication (some contests may not be accessible)");
                $this->cookie = null;
            }
        }

        return true;
    }

    /**
     * Validate a Vjudge cookie by making a test request
     */
    private function validateCookie(string $cookie): array
    {
        try {
            $response = Http::withHeaders([
                'accept' => '*/*',
                'cookie' => $cookie,
                'x-requested-with' => 'XMLHttpRequest'
            ])->get(self::VJUDGE_API['BASE_URL'] . self::VJUDGE_API['ENDPOINTS']['USER_UPDATE']);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['username'])) {
                    return [
                        'success' => true,
                        'username' => $data['username']
                    ];
                }
            }
        } catch (Exception $e) {
            Log::error("Vjudge cookie validation error: " . $e->getMessage());
        }

        return [
            'success' => false,
            'error' => 'Invalid cookie'
        ];
    }

    /**
     * Extract contest ID from a Vjudge URL
     */
    private function extractContestId(?string $eventLink): ?string
    {
        if (!$eventLink) {
            return null;
        }

        $match = preg_match('/contest\\/(\\d+)/', $eventLink, $matches);

        return $match ? $matches[1] : null;
    }

    /**
     * Process a single Vjudge contest
     */
    private function processSingleVjudgeContest(Event $event, string $contestId, string $progress): array
    {
        $this->info("📊 Processing contest {$progress}: {$event->title} (ID: {$contestId})");

        try {
            // Find all users with Vjudge handles in the ranklists associated with this event
            $usersWithHandles = $event->rankLists->pluck('users')
                ->flatten()
                ->filter(function ($user) {
                    return !empty($user->vjudge_handle);
                })
                ->unique('id')
                ->values();

            if ($usersWithHandles->isEmpty()) {
                $this->warn("No users with Vjudge handles found for this contest");
                return [
                    'status' => 'skipped',
                    'reason' => 'No users with handles',
                    'usersProcessed' => 0
                ];
            }

            $this->info("Found {$usersWithHandles->count()} users to process");

            // Fetch data from Vjudge API
            $contestResult = $this->fetchVjudgeStandings($contestId);

            if (!$contestResult['success']) {
                $this->line("<fg=yellow>Try again later or check if contest ID {$contestId} exists on Vjudge.</>");

                Log::warning('Vjudge API fetch failed for contest', [
                    'contestId' => $contestId,
                    'eventTitle' => $event->title,
                    'error' => $contestResult['error']
                ]);

                return [
                    'status' => 'failed',
                    'reason' => 'API Error',
                    'message' => $contestResult['error']
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
     * Fetch contest standings from Vjudge API
     */
    private function fetchVjudgeStandings(string $contestId): array
    {
        $this->info('Fetching data from Vjudge API');
        $this->line("<fg=gray>API URL: https://vjudge.net/contest/rank/single/{$contestId}</>");

        try {
            $headers = [
                'accept' => '*/*',
                'User-Agent' => 'Mozilla/5.0',
                'x-requested-with' => 'XMLHttpRequest'
            ];

            if ($this->cookie) {
                $headers['cookie'] = $this->cookie;
                $this->line("<fg=gray>Authenticated request with user: {$this->authenticatedUsername}</>");
            } else {
                $this->line("<fg=gray>Non-authenticated request</>");
            }

            $response = Http::timeout(30)
                ->acceptJson()
                ->withHeaders($headers)
                ->get(self::VJUDGE_API['BASE_URL'] . self::VJUDGE_API['ENDPOINTS']['CONTEST_RANK'] . '/' . $contestId);

            if (!$response->successful()) {
                $this->error("⚠️ API request failed with status code: {$response->status()}");
                $this->error("Error details: {$response->reason()}");

                $error = $this->cookie ? "Failed to fetch data: {$response->status()} {$response->reason()}" : "AUTH_REQUIRED";
                
                return [
                    'success' => false,
                    'error' => $error
                ];
            }

            $data = $response->json();
            
            if (!$this->isValidContestData($data)) {
                return [
                    'success' => false,
                    'error' => 'Invalid contest data format'
                ];
            }

            $participantCount = count($data['participants']);
            $problemCount = isset($data['problems']) ? count($data['problems']) : 'unknown';

            $this->info('Successfully retrieved contest data from Vjudge');
            $this->line("Contest ID: <fg=green>{$contestId}</>");
            $this->line("Participants: <fg=green>{$participantCount}</>");
            $this->line("Problems: <fg=green>{$problemCount}</>");

            return ['success' => true, 'data' => $data];
        } catch (Exception $error) {
            $errorMessage = $error->getMessage();
            $this->error("⚠️ Exception during API request: {$errorMessage}");
            $this->line('<fg=red>Stack trace: '.substr($error->getTraceAsString(), 0, 200).'...</>');

            Log::error('Exception during Vjudge API request', [
                'contestId' => $contestId,
                'message' => $errorMessage,
                'trace' => $error->getTraceAsString(),
            ]);

            return ['success' => false, 'error' => "Error fetching contest data: {$errorMessage}"];
        }
    }

    /**
     * Check if the contest data is in the expected format
     */
    private function isValidContestData($data): bool
    {
        return is_array($data) &&
            isset($data['length']) &&
            is_numeric($data['length']) &&
            isset($data['participants']) &&
            is_array($data['participants']);
    }

    /**
     * Process contest results and prepare stats
     */
    private function processContestResults(
        int $eventId,
        Collection $users,
        array $data
    ): array {
        $solveStats = [];
        
        $this->info("Processing statistics for {$users->count()} users");

        $totalSolves = 0;
        $totalUpsolves = 0;
        $userStats = [];

        // Process the Vjudge data
        $processedData = $this->processVjudgeData($data);
        
        foreach ($users as $user) {
            if (empty($user->vjudge_handle)) continue;
            
            $stats = $processedData[$user->vjudge_handle] ?? [
                'solve_count' => 0,
                'upsolve_count' => 0,
                'absent' => true
            ];
            
            $solveCount = $stats['solve_count'];
            $upsolveCount = $stats['upsolve_count'];
            
            $totalSolves += $solveCount;
            $totalUpsolves += $upsolveCount;
            
            $solveStats[] = [
                'user_id' => $user->id,
                'event_id' => $eventId,
                'solve_count' => $solveCount,
                'upsolve_count' => $upsolveCount,
                'participation' => !$stats['absent'],
            ];
            
            // Add to user stats for logging
            $userStats[] = [
                'handle' => $user->vjudge_handle,
                'solves' => $solveCount,
                'upsolves' => $upsolveCount,
                'total' => $solveCount + $upsolveCount,
                'participated' => !$stats['absent'] ? 'Yes' : 'No',
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
     * Process the raw Vjudge data to extract solve statistics
     */
    private function processVjudgeData(array $data): array
    {
        $timeLimit = $data['length'] / 1000; // Convert to seconds
        $processed = [];

        // Initialize data structure for each participant
        foreach ($data['participants'] as $participantId => $participant) {
            $username = $participant[0];
            $processed[$username] = [
                'solve_count' => 0,
                'upsolve_count' => 0,
                'absent' => true,
                'solved' => array_fill(0, 50, 0) // Assuming max 50 problems
            ];
        }

        // Process submissions
        if (isset($data['submissions']) && is_array($data['submissions'])) {
            // First pass: Process in-contest solves
            foreach ($data['submissions'] as $submission) {
                $participantId = $submission[0];
                $problemIndex = $submission[1];
                $isAccepted = $submission[2];
                $timestamp = $submission[3];
                
                $participant = $data['participants'][$participantId] ?? null;
                if (!$participant) continue;

                $username = $participant[0];
                if (!isset($processed[$username])) continue;

                if ($timestamp <= $timeLimit) {
                    $processed[$username]['absent'] = false;
                    if ($isAccepted === 1 && !$processed[$username]['solved'][$problemIndex]) {
                        $processed[$username]['solve_count']++;
                        $processed[$username]['solved'][$problemIndex] = 1;
                    }
                }
            }
            
            // Second pass: Process upsolves (after contest)
            foreach ($data['submissions'] as $submission) {
                $participantId = $submission[0];
                $problemIndex = $submission[1];
                $isAccepted = $submission[2];
                $timestamp = $submission[3];
                
                $participant = $data['participants'][$participantId] ?? null;
                if (!$participant) continue;

                $username = $participant[0];
                if (!isset($processed[$username])) continue;

                if ($timestamp > $timeLimit && $isAccepted === 1 && !$processed[$username]['solved'][$problemIndex]) {
                    $processed[$username]['upsolve_count']++;
                    $processed[$username]['solved'][$problemIndex] = 1;
                }
            }
        }

        return $processed;
    }

    /**
     * Update solve stats in the database
     */
    private function updateSolveStatsInDatabase(array $stats): void
    {
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
                        'user_id' => $stat['user_id'],
                        'event_id' => $stat['event_id']
                    ],
                    [
                        'solve_count' => $stat['solve_count'],
                        'upsolve_count' => $stat['upsolve_count'],
                        'participation' => $stat['participation'],
                        'updated_at' => now()
                    ]
                );
            }
        }
    }

    /**
     * Display summary of the update process
     */
    private function displaySummary(int $successCount, int $failedCount, int $skippedCount, $events, int $duration): void
    {
        $endTime = now();

        $this->newLine();
        $this->info('📈 Vjudge Contest Statistics Update Complete');
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Contests', $events->count()],
                ['Successfully Updated', $successCount],
                ['Failed', $failedCount],
                ['Skipped', $skippedCount],
                ['Duration', $this->formatDuration($duration)]
            ]
        );

        // Calculate overall statistics
        $totalUsers = collect($this->results)->sum('usersProcessed');
        $totalSolves = collect($this->results)->sum('totalSolves');
        $totalUpsolves = collect($this->results)->sum('totalUpsolves');

        // Display overall statistics if there were successful updates
        if ($successCount > 0) {
            $this->newLine();
            $this->info('📊 Overall Statistics:');
            $this->table(
                ['Metric', 'Value'],
                [
                    ['Total Users Processed', $totalUsers],
                    ['Total Contest Solves', $totalSolves],
                    ['Total Upsolves', $totalUpsolves],
                    ['Total Problems Solved', $totalSolves + $totalUpsolves],
                ]
            );
        }

        // If there were failures, display additional information
        if ($failedCount > 0) {
            $this->newLine();
            $this->warn('⚠️ Failed Contests:');

            $failedContests = collect($this->results)->filter(function ($result) {
                return $result['status'] === 'failed';
            });
            
            $failedRows = [];
            foreach ($failedContests as $contest) {
                $failedRows[] = [
                    $contest['eventId'],
                    $contest['title'],
                    $contest['reason'] ?? 'Unknown error',
                ];
            }

            $this->table(
                ['Event ID', 'Title', 'Reason'],
                $failedRows
            );

            $this->line('<fg=yellow>To retry a specific failed contest, use:</>');
            $this->line('<fg=yellow>php artisan app:update-vjudge-contests --id=[EVENT_ID]</>');
        }

        // Add a recommendation for future runs
        if ($events->count() > 5) {
            $this->newLine();
            $this->line('<fg=blue>💡 Tip: For faster processing, you can process contests in smaller batches:</>');
            $this->line('<fg=blue>   php artisan app:update-vjudge-contests --limit=5</>');
        }
        
        // Display authentication status in summary
        $this->newLine();
        if ($this->authenticatedUsername) {
            $this->line("Authentication Status: <fg=green>Authenticated as {$this->authenticatedUsername}</>");
        } else {
            $this->line("Authentication Status: <fg=yellow>Not authenticated</>");
        }
    }

    /**
     * Format duration in seconds to a human-readable string
     */
    private function formatDuration(int $seconds): string
    {
        if ($seconds < 60) {
            return $seconds . ' seconds';
        }

        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;

        if ($minutes < 60) {
            return sprintf('%d minutes %d seconds', $minutes, $seconds);
        }

        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;

        return sprintf('%d hours %d minutes %d seconds', $hours, $minutes, $seconds);
    }
}
