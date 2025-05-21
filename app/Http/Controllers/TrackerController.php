<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\RankList;
use App\Models\Tracker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackerController extends Controller
{
    /**
     * Display a listing of the trackers.
     */
    public function index(): View
    {
        $trackers = Tracker::where('status', 'published')
            ->orderBy('order')
            ->paginate(10);
            
        return view('pages.trackers.index', compact('trackers'));
    }

    /**
     * Display the specified tracker with its ranklists.
     */
    public function show(string $slug, Request $request): View
    {
        $tracker = Tracker::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
        
        // Get the requested ranklist by keyword or default to the first one
        $keyword = $request->query('keyword');
        
        if ($keyword) {
            $ranklist = $tracker->rankLists()
                ->where('keyword', $keyword)
                ->where('is_active', true)
                ->firstOrFail();
        } else {
            $ranklist = $tracker->rankLists()
                ->where('is_active', true)
                ->orderBy('order')
                ->firstOrFail();
        }
        
        // Get other ranklists for this tracker
        $otherRanklists = $tracker->rankLists()
            ->where('is_active', true)
            ->where('id', '!=', $ranklist->id)
            ->orderBy('order')
            ->get();
        
        // Get users and events for the ranklist
        $users = $ranklist->users;
        $events = $ranklist->events;
        
        // Load solve stats for all events
        foreach ($events as $event) {
            $event->userSolveStats = $event->userSolveStats()->get();
        }
        
        return view('pages.trackers.show', compact('tracker', 'ranklist', 'otherRanklists', 'users', 'events'));
    }
} 