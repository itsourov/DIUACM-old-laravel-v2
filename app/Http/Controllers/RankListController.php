<?php

namespace App\Http\Controllers;

use App\Models\RankList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RankListController extends Controller
{
    /**
     * Download the ranklist data as CSV
     * 
     * @param RankList $rankList
     * @return StreamedResponse
     */
    public function downloadCsv(RankList $rankList)
    {
        $fileName = 'ranklist-' . $rankList->keyword . '-' . date('Y-m-d') . '.csv';
        
        // Load relationship with users and their scores
        $rankList->load([
            'users' => function ($query) {
                $query->select('users.id', 'name', 'username')
                    ->orderByPivot('score', 'desc');
            }
        ]);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['Rank', 'Name', 'Username', 'Score'];

        $callback = function() use ($rankList, $columns) {
            $file = fopen('php://output', 'w');
            
            // Add CSV header
            fputcsv($file, $columns);
            
            // Add data rows
            $rank = 1;
            foreach ($rankList->users as $user) {
                fputcsv($file, [
                    $rank++,
                    $user->name,
                    $user->username,
                    $user->pivot->score,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
