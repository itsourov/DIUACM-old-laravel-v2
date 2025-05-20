<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSolveStatOnEvent;
use Illuminate\Http\Request;

class ProgrammerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = User::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%")
                      ->orWhere('codeforces_handle', 'like', "%{$search}%")
                      ->orWhere('department', 'like', "%{$search}%")
                      ->orWhere('student_id', 'like', "%{$search}%");
                });
            })
            ->orderBy('max_cf_rating', 'desc')
            ->orderBy('name');
            
        $programmers = $query->paginate(12)->withQueryString();
        
        return view('pages.programmer.index', compact('programmers', 'search'));
    }

    public function show($username)
    {
        $programmer = User::where('username', $username)
            ->with([
                'media',
                'teams' => function ($query) {
                    $query->with(['contest' => function ($q) {
                        $q->orderBy('date', 'desc');
                    }, 'members']);
                },
                'attendedEvents' => function ($query) {
                    $query->orderBy('starting_at', 'desc');
                }
            ])
            ->firstOrFail();
            
        return view('pages.programmer.show', compact('programmer'));
    }
}
