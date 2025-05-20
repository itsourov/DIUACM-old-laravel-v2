<?php

namespace App\Http\Controllers;

use App\Models\Contest;

class ContestController extends Controller
{
    public function index()
    {
        $contests = Contest::with(['teams'])
            ->withCount('teams')
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('pages.contest.index', compact('contests'));
    }

    public function show($id)
    {
        $contest = Contest::with([
            'gallery.media',
            'teams',
            'teams.members',
        ])->findOrFail($id);

        return view('pages.contest.show', compact('contest'));
    }
}
