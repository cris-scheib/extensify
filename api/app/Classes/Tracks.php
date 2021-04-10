<?php

namespace App\Classes;
use App\Models\Track;
use App\Models\Artist;
use App\Models\UserTrack;
use App\Classes\Spotify\Tracks as SpotifyTracks;
use Illuminate\Support\Facades\DB;

class Tracks
{
    private $trackModel;
    private $artistModel;
    private $userTrackModel;

    public function __construct()
    {
        $this->trackModel = new Track();
        $this->artistModel = new Artist();
        $this->userTrackModel = new UserTrack();
    }

    public function syncTracks($user)
    {
        $spotifyTracks = new SpotifyTracks();
        $data = $spotifyTracks->getTracks($user->token);

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
                $userTrack = $this->userTrackModel
                    ->where('track_id', $track->id)
                    ->where('user_id', $track->id)
                    ->first();
                if ($userTrack === null) {
                    $userTrack = $this->userTrackModel->create([
                        'track_id' => $track->id,
                        'user_id' => $user->id,
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }
}
