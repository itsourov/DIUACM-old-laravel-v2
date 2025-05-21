<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index(Request $request): View
    {
        $query = Event::query()
            ->where('status', 'published')
            ->orderBy('starting_at', 'desc');

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('title', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%");
        }

        $events = $query->paginate(10);

        return view('pages.events.index', compact('events'));
    }

    /**
     * Display the specified event.
     */
    public function show($id): View
    {
        $event = Event::findOrFail($id);

        // Check if the event has already ended
        $hasEnded = Carbon::now()->isAfter($event->ending_at);

        // Calculate event duration in hours (rounded to 1 decimal place)
        $durationHours = $event->starting_at->diffInMinutes($event->ending_at) / 60;
        $durationFormatted = number_format($durationHours, 1);

        // Get attendees with pagination, ensuring we have the media relationship loaded
        $attendees = $event->attendedUsers()->with('media')->paginate(20);
        $attendeesCount = $event->attendedUsers()->count();

        // Check if current user has marked attendance
        $hasAttended = false;
        if (auth()->check()) {
            $hasAttended = $event->attendedUsers()->where('user_id', auth()->id())->exists();
        }

        return view('pages.events.show', compact(
            'event',
            'hasEnded',
            'durationFormatted',
            'attendees',
            'attendeesCount',
            'hasAttended'
        ));
    }

    /**
     * Mark attendance for an event
     */
    public function markAttendance(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Validate if attendance is open
        if (! $event->open_for_attendance) {
            return back()->with('error', 'Attendance is not open for this event.');
        }

        // Validate event password if needed
        if ($event->event_password && $event->event_password !== $request->password) {
            return back()->with('error', 'Incorrect event password.');
        }

        // Check if user already marked attendance
        if ($event->attendedUsers()->where('user_id', auth()->id())->exists()) {
            return back()->with('info', 'You have already marked your attendance.');
        }

        // Mark attendance
        $event->attendedUsers()->attach(auth()->id());

        return back()->with('success', 'Attendance marked successfully!');
    }
}
