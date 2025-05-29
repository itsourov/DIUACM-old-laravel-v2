<?php

namespace App\Http\Controllers;

use App\Enums\EventType;
use App\Http\Resources\VjudgeContestResource;
use App\Models\Event;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    public function getVjudgeEvents(Request $request)
    {
        $activeContests = Event::where('type', EventType::CONTEST)
            ->where('event_link', 'LIKE', '%vjudge.net%')
            ->whereHas('rankLists', function ($query) {
                $query->where('is_active', true);
            })
            ->select('id', 'title', 'event_link', 'starting_at')
            ->orderBy('starting_at', 'desc')
            ->get();
        return VjudgeContestResource::collection($activeContests);
    }

    public function postVjudgeEvents(Request $request, Event $event)
    {
       

        return response()->json(['message' => 'Vjudge event updated successfully.'], 200);
    }
}
