<?php

namespace App\Classes;
use App\Models\Recommendation;
use App\Models\Artist;
use App\Classes\Artists;
use App\Models\History;
use App\Models\UserFollowedArtist;
use App\Classes\Spotify\Recommendations as SpotifyRecommendations;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Recommendations
{
    private $recommendationModel;
    private $userFollowedArtistModel;
    private $artistModel;
    private $artists;
    private $historyModel;

    public function __construct()
    {
        $this->recommendationModel = new Recommendation();
        $this->artistModel = new Artist();
        $this->historyModel = new History();
        $this->artists = new Artists();
        $this->userFollowedArtistModel = new UserFollowedArtist();
    }

    public function syncRecommendations($user)
    {
        $this->recommendationModel->where('user_id', $user->id)->delete();
        $spotifyRecommendations = new SpotifyRecommendations();
        $artists = $this->historyModel
            ->selectRaw(
                "artists.id as artist, count('artist'), artists.spotify_id as seed"
            )
            ->join('tracks', 'history.track_id', 'tracks.id')
            ->join('artists', 'artists.id', 'tracks.artist_id')
            ->groupBy('artist')
            ->orderBy('count', 'DESC')
            ->whereBetween('history.played_at', [
                Carbon::now()
                    ->subDays(14)
                    ->format('Y-m-d H:i:s'),
                Carbon::now()->format('Y-m-d H:i:s'),
            ])
            ->take(5)
            ->get();

        foreach ($artists as $artist) {
            $data = $spotifyRecommendations->getRecommendations(
                $user,
                $artist->seed
            );

            $this->syncData(
                $user,
                $data,
                $this->recommendationModel,
                $artist->seed
            );
            echo 'ok \n';
        }
    }

    private function syncData($user, $data, $model, $seed)
    {
        DB::beginTransaction();
        try {
            foreach ($data->tracks as $spotifyRecommendation) {
                $artist = $this->artistModel
                    ->where(
                        'spotify_id',
                        $spotifyRecommendation->artists[0]->id
                    )
                    ->first();
                if ($artist === null) {
                    $artist = $this->getArtist(
                        $spotifyRecommendation->artists[0]->id
                    );
                    $artist = $this->artistModel->create([
                        'name' => $artist->name,
                        'spotify_id' => $artist->id,
                        'image' => $artist->images[0]->url,
                    ]);
                }
                $followed = $this->userFollowedArtistModel
                    ->where('user_id', $user->id)
                    ->where('artist_id', $artist->id)
                    ->first();
                if ($followed === null) {
                    $recommendation = $this->recommendationModel
                        ->where('artist_id', $artist->id)
                        ->first();

                    if ($recommendation === null) {
                        $recommendation = $this->recommendationModel->create([
                            'artist_id' => $artist->id,
                            'user_id' => $user->id,
                            'seed' => $seed,
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
        }
    }

    private function getArtist($artist)
    {
        $user = Cache::get('user');
        return $this->artists->getArtist($user, $artist);
    }
}
