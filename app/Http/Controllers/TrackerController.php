<?php

namespace App\Http\Controllers;

use App\Enums\Visibility;
use App\Models\RankList;
use App\Models\Tracker;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackerController extends Controller
{
    /**
     * Display a listing of the trackers.
     */
    public function index(): View
    {
        $trackers = Tracker::where('status', Visibility::PUBLISHED)
            ->orderBy('order')
            ->paginate(10);

        return view('pages.trackers.index', compact('trackers'));
    }

    /**
     * Display the specified tracker with its ranklists.
     */
    public function show(string $slug, Request $request)
    {

        $keyword = $request->query('keyword');

        $tracker = Tracker::where('slug', $slug)
            ->where('status', Visibility::PUBLISHED)
            ->firstOrFail();

        // Get all keywords from ranklists for this tracker
        $allRankListKeywords = $tracker->rankLists()
            ->pluck('keyword')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $ranklist = $tracker->rankLists()
            ->when($keyword, function ($query) use ($keyword) {
                return $query->where('keyword', $keyword);
            })
            ->orderBy('order')
            ->first();

        if (!$ranklist) {
            abort(404, 'No rank lists available for this tracker');
        }

        $ranklist->load([
            'users' => function ($query) {
                $query->select('users.id', 'name', 'username', 'codeforces_handle')
                    ->orderByPivot('score', 'desc');
            },
            'users.media' => function ($query) {
                $query->where('collection_name', 'avatar')
                    ->latest()
                    ->limit(1);
            },
            'users.solveStats' => function ($query) use ($ranklist) {
                $query->whereIn('event_id', $ranklist->events->pluck('id'));
            },
            'events' => function ($query) {
                $query->select('events.id', 'title', 'starting_at')
                    ->withPivot('weight')
                    ->orderBy('starting_at', 'desc');
            },
        ]);

        return view('pages.trackers.show', compact('tracker', 'ranklist', 'allRankListKeywords'));
    }

    /**
     * Join a ranklist
     */
    public function joinRankList(RankList $rankList)
    {

        // Check if user is already part of this ranklist
        if ($rankList->users()->where('user_id', auth()->id())->exists()) {
            Notification::make()
                ->title('You are already part of this ranklist.')
                ->info()
                ->send();
            return back();

        }

        // Add user to ranklist with initial score of 0
        $rankList->users()->attach(auth()->id(), ['score' => 0]);

        Notification::make()
            ->title('You have successfully joined the ranklist.')
            ->success()
            ->send();

        return back();
    }

    /**
     * Leave a ranklist
     */
    public function leaveRankList(RankList $rankList)
    {

        // Check if user is part of this ranklist
        if (!$rankList->users()->where('user_id', auth()->id())->exists()) {
            Notification::make()
                ->title('You are not part of this ranklist.')
                ->info()
                ->send();

            return back();
        }

        // Remove user from ranklist
        $rankList->users()->detach(auth()->id());

        Notification::make()
            ->title('You have successfully left the ranklist.')
            ->success()
            ->send();

        return back();
    }
}
