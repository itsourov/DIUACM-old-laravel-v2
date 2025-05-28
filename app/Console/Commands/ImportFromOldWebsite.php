<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\RankList;
use App\Models\Tracker;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ImportFromOldWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-from-old-website';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users, events, and ranklists from the old DIU ACM website';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->importUsers();
        $this->importEvents();
        $this->importRankListUsers();
    }

    public function importUsers(): void
    {
        try {
            $oldUsers = Http::get('https://admin.diuacm.com/api/users')->json();
        } catch (ConnectionException $e) {
            $this->error("Failed to fetch users: {$e->getMessage()}");
            return;
        }

        foreach ($oldUsers as $user) {
            $user['gender'] = $user['gender'] === 'unspecified' ? null : $user['gender'];

            $newUser = User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );

            if (!empty($user['image'])) {
                $user['image'] = Str::replace(
                    'https://nextacm.sgp1.cdn.digitaloceanspaces.com',
                    'https://pub-83bcfd6cb2074761b76b8be8a3e87316.r2.dev',
                    $user['image']
                );

                try {
                    $newUser->addMediaFromUrl($user['image'])
                        ->preservingOriginal(false)
                        ->toMediaCollection('avatar', 'avatar');
                } catch (FileDoesNotExist | FileIsTooBig | FileCannotBeAdded $e) {
                    $this->error("Failed to add media for user {$user['email']}: {$e->getMessage()}");
                }
            }

            $this->info("User {$user['email']} imported.");
        }
    }

    public function importEvents(): void
    {
        try {
            $oldEvents = Http::get('https://admin.diuacm.com/api/events')->json();
        } catch (ConnectionException $e) {
            $this->error("Failed to fetch events: {$e->getMessage()}");
            return;
        }

        foreach ($oldEvents as $event) {
            $existingEvent = Event::where('title', $event['title'])
                ->where('event_link', $event['event_link'])
                ->first();

            if ($existingEvent) {
                $this->info("Event {$event['id']} already exists. Skipping.");
            } else {
                $existingEvent = Event::create($event);
                $this->info("Event {$event['id']} imported.");
            }

            foreach ($event['attenders'] ?? [] as $user) {
                $DbUser = User::where('email', $user['email'])->first();
                if ($DbUser) {
                    $existingEvent->attendedUsers()->syncWithoutDetaching($DbUser->id);
                    $this->info("User $DbUser->email attended event {$event['id']}.");
                } else {
                    $this->error("User {$user['email']} not found. Skipping.");
                }
            }

            foreach ($event['rank_lists'] ?? [] as $rl) {
                $tracker = Tracker::updateOrCreate(
                    ['slug' => $rl['tracker']['slug']],
                    $rl['tracker']
                );

                $rankList = $tracker->rankLists()->updateOrCreate(
                    ['keyword' => $rl['session']],
                    [
                        'keyword' => $rl['session'],
                        'description' => $rl['description'],
                        'weight_of_upsolve' => $rl['weight_of_upsolve'],
                        'is_active' => !$rl['is_archived'],
                    ]
                );

                $this->info("Rank list $rankList->id created.");
                $rankList->events()->syncWithoutDetaching([
                    $existingEvent->id => ['weight' => $rl['pivot']['weight']],
                ]);
            }
        }
    }

    private function importRankListUsers(): void
    {
        try {
            $rankListData = Http::get('https://admin.diuacm.com/api/ranklists')->json();
        } catch (ConnectionException $e) {
            $this->error("Failed to fetch rank lists: {$e->getMessage()}");
            return;
        }

        foreach ($rankListData as $rl) {
            $rankList = RankList::where('keyword', $rl['session'])->first();

            if (!$rankList) {
                $this->error("Rank list {$rl['session']} not found. Skipping.");
                continue;
            }

            foreach ($rl['users'] ?? [] as $user) {
                $DbUser = User::where('email', $user['email'])->first();
                if ($DbUser) {
                    $rankList->users()->syncWithoutDetaching($DbUser->id);
                    $this->info("User $DbUser->email imported to rank list {$rl['session']}.");
                } else {
                    $this->error("User {$user['email']} not found. Skipping.");
                }
            }
        }
    }
}
