<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classes\History;
use App\Models\History as HistoryModel;
use Illuminate\Support\Facades\Cache;

class HistoryController extends Controller
{
    private $history;
    private $historyModel;

    public function __construct(History $history, HistoryModel $historyModel)
    {
        $this->historyModel = $historyModel;
        $this->history = $history;
    }

    public function Get(Request $request)
    {
        $user = Cache::get('user');
        $userHistory = $this->historyModel
            ->where('user_id', $user->id)
            ->count();
        if ($userHistory == 0) {
            $this->history->syncHistory($user);
        }
        $userHistory = $this->historyModel
            ->join('tracks', 'tracks.id', '=', 'history.track_id')
            ->join('artists', 'artists.id', '=', 'tracks.artist_id')
            ->where('history.user_id', $user->id)
            ->orderby('history.played_at', 'desc');

        if ($request->input('start') !== null) {
            $userHistory = $userHistory->whereDate(
                'history.played_at',
                '>=',
                $request->input('start')
            );
        }
        if ($request->input('end') !== null) {
            $userHistory = $userHistory->whereDate(
                'history.played_at',
                '<=',
                $request->input('end')
            );
        }
        $export = $userHistory
            ->selectRaw(
                'history.played_at, tracks.name as track, artists.name as artist'
            )
            ->get();
        $history = $userHistory
            ->selectRaw(
                "history.played_at as date, tracks.name as track, 
            tracks.spotify_id as track_spotify, artists.name as artist, 
            artists.spotify_id as artist_spotify"
            )
            ->paginate(10);
        $data = [
            'export' => $export,
            'history' => $history,
        ];
        return response()->json($data, 200);
    }
}
