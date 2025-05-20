<?php

namespace App\Console\Commands;

use App\Models\Event;
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

        //        $this->importUsers();
        $this->importEvents();
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
            //            if (isset($user['image'])) {
            //                $user['image'] = Str::replace('https://nextacm.sgp1.cdn.digitaloceanspaces.com', 'https://pub-83bcfd6cb2074761b76b8be8a3e87316.r2.dev', $user['image']);
            //
            //
            //                try {
            //                    $newUser->addMediaFromUrl($user['image'])
            //                        ->toMediaCollection('profile-images', 'profile-images');
            //                } catch (FileDoesNotExist|FileIsTooBig|FileCannotBeAdded $e) {
            //                    $this->error("Failed to add media for user {$user['email']}: {$e->getMessage()}");
            //                }
            //            }

            $this->info("User {$user['email']} imported.");
        }
    }
}
