<?php

namespace App\Classes;
use App\Models\Track;
use App\Models\Artist;
use App\Models\UserFavoriteTrack;
use App\Classes\Spotify\Tracks as SpotifyTracks;
use Illuminate\Support\Facades\DB;

class Tracks
{
    private $trackModel;
    private $artistModel;
    private $userFavoriteTrackModel;

    public function __construct()
    {
        $this->trackModel = new Track();
        $this->artistModel = new Artist();
        $this->userFavoriteTrackModel = new UserFavoriteTrack();
    }

    public function syncFavorite($user)
    {
        $spotifyTracks = new SpotifyTracks();
        $data = $spotifyTracks->getFavoriteTracks($user);
        $this->syncData($user, $data, $this->userFavoriteTrackModel);
    }

    private function syncData($user, $data, $model)
    {
        DB::beginTransaction();
        try {
            foreach ($data->items as $spotifyTrack) {
                $artist = $this->artistModel
                    ->where('spotify_id', $spotifyTrack->artists[0]->id)
                    ->first();
                if ($artist === null) {
                    $artist = $this->artistModel->create([
                        'name' => $spotifyTrack->artists[0]->name,
                        'spotify_id' => $spotifyTrack->artists[0]->id,
                        'image' => null,
                    ]);
                }
                $track = $this->trackModel
                    ->where('spotify_id', $spotifyTrack->id)
                    ->first();

                if ($track === null) {
                    $track = $this->trackModel->create([
                        'name' => $spotifyTrack->name,
                        'spotify_id' => $spotifyTrack->id,
                        'artist_id' => $artist->id,
                    ]);
                }
                $userTrack = $model
                    ->where('track_id', $track->id)
                    ->where('user_id', $track->id)
                    ->first();
                if ($userTrack === null) {
                    $userTrack = $model->create([
                        'track_id' => $track->id,
                        'user_id' => $user->id,
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
