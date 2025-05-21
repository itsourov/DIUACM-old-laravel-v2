<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\RankList;
use App\Models\Tracker;
use App\Models\User;
use Illuminate\Console\Command;
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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->importUsers();
        $this->importEvents();
        $this->importRankListUsers();
    }

    public function importEvents()
    {

        $oldEvents = Http::get('https://admin.diuacm.com/api/events')->json();
        foreach ($oldEvents as $event) {

            $existingEvent = Event::where('title', $event['title'])->where('event_link', $event['event_link'])->first();
            if ($existingEvent) {
                $this->info("Event {$event['id']} already exists. Skipping.");
            } else {
                $existingEvent = Event::create($event);
                $this->info("Event {$event['id']} imported.");
            }

            $attendedUser = $event['attenders'];
            foreach ($attendedUser as $user) {
                $user = User::where('email', $user['email'])->first();
                if ($user) {
                    $existingEvent->attendedUsers()->syncWithoutDetaching($user->id);
                    $this->info("User {$user->email} attended event {$event['id']}.");
                } else {
                    $this->error("User {$user['email']} not found. Skipping.");
                }
            }

            $rankLists = $event['rank_lists'];

            foreach ($rankLists as $rl) {

                $tracker = Tracker::updateOrCreate([
                    'slug' => $rl['tracker']['slug'],
                ],
                    $rl['tracker']
                );
                $rankLists = $tracker->rankLists()->updateOrCreate(
                    [
                        'keyword' => $rl['session'],
                    ],
                    [
                        'keyword' => $rl['session'],
                        'description' => $rl['description'],
                        'weight_of_upsolve' => $rl['weight_of_upsolve'],
                        'is_active' => ! $rl['is_archived'],
                    ]
                );
                $this->info("Rank list {$rankLists->id} created.");

                $rankLists->events()->syncWithoutDetaching([
                    $existingEvent->id => ['weight' => $rl['pivot']['weight']],
                ]);
            }

        }
    }

    public function importUsers(): void
    {
        $oldUsers = Http::get('https://admin.diuacm.com/api/users')->json();
        foreach ($oldUsers as $user) {
            $user['gender'] = $user['gender'] === 'unspecified' ? null : $user['gender'];
            $newUser = User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
            if (isset($user['image'])) {
                $user['image'] = Str::replace('https://nextacm.sgp1.cdn.digitaloceanspaces.com', 'https://pub-83bcfd6cb2074761b76b8be8a3e87316.r2.dev', $user['image']);

                try {
                    $newUser->addMediaFromUrl($user['image'])
                        ->toMediaCollection('avatar', 'avatar');
                } catch (FileDoesNotExist|FileIsTooBig|FileCannotBeAdded $e) {
                    $this->error("Failed to add media for user {$user['email']}: {$e->getMessage()}");
                }
            }

            $this->info("User {$user['email']} imported.");
        }
    }

    private function importRankListUsers(): void
    {
        $rankLists = Http::get('https://admin.diuacm.com/api/ranklists')->json();

        foreach ($rankLists as $rl) {
            $rankLists = RankList::where('keyword', $rl['session'])->first();
            if (! $rankLists) {
                $this->error("Rank list {$rl['session']} not found. Skipping.");

                continue;
            }

            $users = $rl['users'];
            foreach ($users as $user) {
                $user = User::where('email', $user['email'])->first();
                if ($user) {
                    $rankLists->users()->syncWithoutDetaching($user->id);
                    $this->info("User {$user->email} imported to rank list {$rl['session']}.");
                } else {
                    $this->error("User {$user['email']} not found. Skipping.");
                }
            }

        }
    }
}
