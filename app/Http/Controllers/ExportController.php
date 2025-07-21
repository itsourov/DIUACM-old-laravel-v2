<?php

namespace App\Http\Controllers;

use App\Models\RankList;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;


class ExportController extends Controller
{
    public function users(Request $request)
    {
        $users = User::with('media')->get();
        
        $userData = $users->map(function ($user) {
            // Get all user attributes including password
            $userArray = $user->makeVisible(['password'])->toArray();
            
            // Add avatar URL - gets the avatar or fallback URL
            $userArray['avatar_url'] = $user->getFirstMediaUrl('avatar');
            
            return $userArray;
        });
        
        return response()->json([
            'success' => true,
            'data' => $userData,
            'total' => $userData->count()
        ]);
    }

     public function ranklists(Request $request)
    {
        $ranklists = RankList::with('tracker','users')->get();

        return response()->json([
            'success' => true,
            'data' => $ranklists,
            'total' => $ranklists->count()
        ]);
    }

    public function events(Request $request)
    {
        $events = Event::with(['attendedUsers','rankLists'])->get();

        return response()->json([
            'success' => true,
            'data' => $events,
            'total' => $events->count()
        ]);
    }

       
}