<?php

namespace App\Classes;
use App\Models\Track;
use App\Models\Artist;
use App\Models\History as HistoryModel;
use App\Classes\Spotify\History as SpotifyHistory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class History
{
    private $trackModel;
    private $artistModel;
    private $historyModel;

    public function __construct()
    {
        $this->trackModel = new Track();
        $this->artistModel = new Artist();
        $this->historyModel = new HistoryModel();
    }

    public function syncHistory($user)
    {
        $spotifyHistory = new SpotifyHistory();
        $data = $spotifyHistory->getHistory($user);
        $this->syncData($user, $data, $this->historyModel);
    }

    private function syncData($user, $data, $model)
    {
        DB::beginTransaction();
        try {
            foreach ($data->items as $spotifyHistory) {
                $artist = $this->artistModel
                    ->where(
                        'spotify_id',
                        $spotifyHistory->track->album->artists[0]->id
                    )
                    ->first();
                if ($artist === null) {
                    $artist = $this->artistModel->create([
                        'name' =>
                            $spotifyHistory->track->album->artists[0]->name,
                        'spotify_id' =>
                            $spotifyHistory->track->album->artists[0]->id,
                        'image' =>
                            $spotifyHistory->track->album->images[0]->url,
                    ]);
                }
                $track = $this->trackModel
                    ->where('spotify_id', $spotifyHistory->track->id)
                    ->first();

                if ($track === null) {
                    $track = $this->trackModel->create([
                        'name' => $spotifyHistory->track->name,
                        'spotify_id' => $spotifyHistory->track->id,
                        'artist_id' => $artist->id,
                    ]);
                }
                $played_at = Carbon::parse($spotifyHistory->played_at)->format(
                    'Y-m-d H:i:s'
                );
                $userHistory = $model->where('played_at', $played_at)->first();
                if ($userHistory === null) {
                    $userHistory = $model->create([
                        'track_id' => $track->id,
                        'user_id' => $user->id,
                        'played_at' => $played_at,
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
