<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\User;
use App\Models\UserSolveStatOnEvent;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class UpdateAtcoderContestes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-atcoder-contestes
                           {--limit= : Limit the number of contests to process}
                           {--id= : Process a specific contest/event by ID}
                           {--fresh : Clear existing stats before updating}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates solve statistics for AtCoder contests by calculating contest solves and upsolves for each user';

    /**
     * The AtCoder API endpoints
     */
    protected const ATCODER_API = [
        'CONTESTS' => 'https://kenkoooo.com/atcoder/resources/contests.json',
        'SUBMISSIONS' => 'https://kenkoooo.com/atcoder/atcoder-api/v3/user/submissions',
    ];
    
    /**
     * cURL resource
     */
    private $curl;
    
    /**
     * Stats for the current event being processed
     */
    private $currentEventStats = [];

    public function __construct()
    {
        parent::__construct();
        $this->curl = curl_init();
        curl_setopt_array($this->curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
    }

    public function __destruct()
    {
        if ($this->curl) {
            curl_close($this->curl);
        }
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->displayHeader();

        // Handle fresh option - clear existing stats if requested
        if ($this->option('fresh')) {
            if ($this->confirm('This will delete all existing AtCoder solve statistics. Continue?', false)) {
                $this->info('Clearing existing statistics...');
                UserSolveStatOnEvent::whereHas('event', function ($query) {
                    $query->where('event_link', 'like', '%atcoder.jp%');
                })->delete();
                $this->info('Existing statistics cleared.');
            } else {
                $this->info('Operation cancelled.');
                return 1;
            }
        }

        // Get active ranklists
        $ranklists = Event::where('event_link', 'like', '%atcoder.jp%')
            ->whereHas('rankLists', function ($query) {
                $query->where('is_active', true);
            })
            ->get();
            
        $this->line('Found ' . $this->formatValue($ranklists->count()) . ' active ranklists with AtCoder contests');
        $this->newLine();

        // Get the events
        $query = Event::where('event_link', 'like', '%atcoder.jp%')
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
            $this->info('No AtCoder contests found to process');
            return 0;
        }

        // Process each event
        foreach ($events as $event) {
            $this->processEvent($event);
        }
        
        $this->displayFooter();

        $this->displayFooter();

        return 0;
    }

    /**
     * Extract contest ID from an AtCoder URL
     */
    private function extractContestId(?string $eventLink): ?string
    {
        if (! $eventLink) {
            return null;
        }
        
        $parsedUrl = parse_url($eventLink);
        $pathSegments = explode('/', trim($parsedUrl['path'] ?? '', '/'));
        $contestID = $pathSegments[1] ?? null;
        
        return ($pathSegments[0] ?? '') === 'contests' && $contestID ? $contestID : null;
    }

    /**
     * Display header for the command
     */
    private function displayHeader()
    {
        $this->line('╔════════════════════════════════════════════════════════════╗');
        $this->line('║                    AtCoder Stats Update                    ║');
        $this->line('╠════════════════════════════════════════════════════════════╣');
        $this->line('║ Started by: ' . str_pad(get_current_user(), 45) . ' ║');
        $this->line('║ Start time: ' . str_pad(now()->format('Y-m-d H:i:s') . ' UTC', 45) . ' ║');
        $this->line('╚════════════════════════════════════════════════════════════╝');
        $this->newLine();
    }

    /**
     * Display footer for the command
     */
    private function displayFooter()
    {
        $this->newLine();
        $endTime = now()->format('Y-m-d H:i:s');
        $this->line('╔════════════════════════════════════════════════════════════╗');
        $this->line('║                      Update Complete                       ║');
        $this->line('║ End time: ' . str_pad($endTime . ' UTC', 45) . ' ║');
        $this->line('╚════════════════════════════════════════════════════════════╝');
    }
    
    /**
     * Display event header
     */
    private function displayEventHeader(Event $event)
    {
        $this->newLine();
        $this->line('┌' . str_repeat('─', 98) . '┐');
        $this->line('│ Event: ' . str_pad($event->title, 90) . '│');
        $this->line('├' . str_repeat('─', 98) . '┤');
        $this->displayTableHeader();
    }

    /**
     * Display table header for user stats
     */
    private function displayTableHeader()
    {
        $format = "│ %-20s │ %-20s │ %-7s │ %-8s │ %-7s │ %-8s │";
        $this->line(sprintf($format,
            'Username',
            'AtCoder Handle',
            'Solved',
            'Upsolved',
            'Present',
            'Time'
        ));
        $this->line('├' . str_repeat('─', 98) . '┤');
    }

    /**
     * Display user row in the table
     */
    private function displayUserRow($user)
    {
        $format = "│ %-20s │ %-20s │ %-7d │ %-8d │ %-7s │ %-8s │";
        $this->line(sprintf($format,
            $this->truncate($user['username'], 20),
            $this->truncate($user['atcoder_handle'], 20),
            $user['solved'],
            $user['upsolved'],
            $user['present'],
            $user['timestamp']
        ));
    }

    /**
     * Display event summary
     */
    private function displayEventSummary()
    {
        $users = $this->currentEventStats['users'];
        $totalUsers = count($users);
        $presentUsers = count(array_filter($users, fn($u) => $u['present'] === '✓'));
        $totalSolved = array_sum(array_column($users, 'solved'));
        $totalUpsolved = array_sum(array_column($users, 'upsolved'));

        $this->line('├' . str_repeat('─', 98) . '┤');
        $this->line('│ Summary:' . str_pad('', 89) . '│');
        $summaryText = sprintf(
            "Total Users: %d | Present: %d | Problems Solved: %d | Upsolved: %d",
            $totalUsers,
            $presentUsers,
            $totalSolved,
            $totalUpsolved
        );
        $this->line('│ ' . str_pad($summaryText, 96) . ' │');
        $this->line('└' . str_repeat('─', 98) . '┘');
        $this->newLine();
    }

    /**
     * Truncate string to a certain length
     */
    private function truncate($string, $length)
    {
        return strlen($string) > $length
            ? substr($string, 0, $length - 3) . '...'
            : str_pad($string, $length);
    }

    /**
     * Format value with bold styling
     */
    private function formatValue($value)
    {
        return "<options=bold>$value</>";
    }

    /**
     * Format text in a box
     */
    private function formatBox($text)
    {
        return "【 $text 】";
    }

    /**
     * Fetch URL using curl
     */
    private function fetchUrl(string $url): false|string
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        $response = curl_exec($this->curl);

        if (curl_errno($this->curl)) {
            $this->error('cURL Error: ' . curl_error($this->curl));
            return false;
        }

        return $response;
    }

    /**
     * Process a single event
     */
    private function processEvent(Event $event)
    {
        $this->currentEventStats = [
            'title' => $event->title,
            'users' => [],
        ];

        $this->info($this->formatBox('Processing event: ' . $event->title));

        // Extract contest ID from event link
        $contestId = $this->extractContestId($event->event_link);
        if (!$contestId) {
            $this->warn("Invalid contest URL: {$event->event_link}");
            return;
        }

        $users = User::whereNotNull('atcoder_handle')
            ->whereHas('rankLists', function ($query) use ($event) {
                $query->whereHas('events', function ($q) use ($event) {
                    $q->where('events.id', $event->id);
                });
            })
            ->get(['id', 'name', 'atcoder_handle']);

        if ($users->isEmpty()) {
            $this->warn('No users found with AtCoder handles for event: ' . $event->title);
            return;
        }

        $this->displayEventHeader($event);

        foreach ($users as $user) {
            $this->processUserEvent($event, $user);
        }

        $this->displayEventSummary();
    }

    /**
     * Process a user's submissions for an event
     */
    private function processUserEvent(Event $event, User $user)
    {
        if (!$event || !$user || !(str_contains($event->event_link, 'atcoder.jp'))) {
            $this->recordStats($event, $user, 0, 0, false);
            return;
        }

        $contestDataResponse = Cache::remember('atcoder_contests', 60 * 60 * 2, function () {
            return $this->fetchUrl(self::ATCODER_API['CONTESTS']);
        });

        if (!$contestDataResponse) {
            $this->recordStats($event, $user, 0, 0, false);
            return;
        }

        $contestID = $this->extractContestId($event->event_link);
        if (!$contestID) {
            $this->recordStats($event, $user, 0, 0, false);
            return;
        }

        $atcoder_username = $user->atcoder_handle ?? null;
        if (!$atcoder_username) {
            $this->recordStats($event, $user, 0, 0, false);
            return;
        }

        $contestData = json_decode($contestDataResponse, true);
        $contestInfo = collect($contestData)->firstWhere('id', $contestID);

        if (!$contestInfo) {
            $this->recordStats($event, $user, 0, 0, false);
            return;
        }

        $submissionResponse = $this->fetchUrl(
            self::ATCODER_API['SUBMISSIONS'] . "?user=" . urlencode($atcoder_username) . "&from_second={$contestInfo['start_epoch_second']}"
        );

        if (!$submissionResponse) {
            $this->recordStats($event, $user, 0, 0, false);
            return;
        }

        $submissions = json_decode($submissionResponse, true);
        $solvedProblems = [];
        $upsolvedProblems = [];
        $absent = true;
        $contestEnd = $contestInfo['start_epoch_second'] + $contestInfo['duration_second'];

        foreach ($submissions as $submission) {
            if ($submission['contest_id'] !== $contestID) continue;

            $submissionTime = $submission['epoch_second'];
            $problemID = $submission['problem_id'];
            $result = $submission['result'];

            if ($result === 'AC') {
                if ($submissionTime >= $contestInfo['start_epoch_second'] && $submissionTime <= $contestEnd) {
                    $absent = false;
                    $solvedProblems[$problemID] = true;
                } elseif ($submissionTime > $contestEnd && !isset($solvedProblems[$problemID])) {
                    $upsolvedProblems[$problemID] = true;
                }
            } elseif ($submissionTime >= $contestInfo['start_epoch_second'] && $submissionTime <= $contestEnd) {
                $absent = false;
            }
        }

        $this->recordStats(
            $event,
            $user,
            count($solvedProblems),
            count($upsolvedProblems),
            !$absent
        );
    }

    /**
     * Record statistics for a user's event performance
     */
    private function recordStats(Event $event, User $user, $solveCount, $upsolveCount, $isPresent)
    {
        UserSolveStatOnEvent::updateOrCreate([
            'event_id' => $event->id,
            'user_id' => $user->id,
        ], [
            'solve_count' => $solveCount,
            'upsolve_count' => $upsolveCount,
            'participation' => $isPresent,
        ]);

        $this->currentEventStats['users'][] = [
            'username' => $user->name,
            'atcoder_handle' => $user->atcoder_handle ?? 'Not set',
            'solved' => $solveCount,
            'upsolved' => $upsolveCount,
            'present' => $isPresent ? '✓' : '✗',
            'timestamp' => date('H:i:s'),
        ];

        $this->displayUserRow(end($this->currentEventStats['users']));
    }
}
