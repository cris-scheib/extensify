<?php

namespace App\Classes;
use App\Models\ArtistGenre;
use App\Models\UserFavoriteArtist;
use App\Models\UserFollowedArtist;
use App\Models\Artist;
use App\Models\Genre;
use App\Classes\Spotify\Artists as SpotifyArtists;
use Illuminate\Support\Facades\DB;

class Artists
{
    private $artistModel;
    private $genreModel;
    private $artistGenreModel;
    private $userFollowedArtistModel;
    private $userFavoriteArtistModel;

    public function __construct()
    {
        $this->artistModel = new Artist();
        $this->genreModel = new Genre();
        $this->artistGenreModel = new ArtistGenre();
        $this->userFavoriteArtistModel = new UserFavoriteArtist();
        $this->userFollowedArtistModel = new UserFollowedArtist();
    }

    public function unfollow($user, $artist)
    {
        $apotifyArtists = new SpotifyArtists();
        $data = $apotifyArtists->unfollow($user, $artist->spotify_id);
        dd($data);
    }
    public function syncFavorite($user)
    {
        $apotifyArtists = new SpotifyArtists();
        $data = $apotifyArtists->getFavorite($user);
        $this->syncData($user, $data, $this->userFavoriteArtistModel);
    }

    public function syncFollowed($user)
    {
        $apotifyArtists = new SpotifyArtists();
        $data = $apotifyArtists->getFollowed($user);
        $this->syncData($user, $data->artists, $this->userFollowedArtistModel);
    }

    private function syncData($user, $data, $model)
    {
        DB::beginTransaction();
        try {
            foreach ($data->items as $spotifyArtist) {
                $artist = $this->artistModel
                    ->where('spotify_id', $spotifyArtist->id)
                    ->first();
                if ($artist === null) {
                    $artist = $this->artistModel->create([
                        'name' => $spotifyArtist->name,
                        'spotify_id' => $spotifyArtist->id,
                        'image' => $spotifyArtist->images[0]->url,
                    ]);
                }
                $userArtist = $model
                    ->where('artist_id', $artist->id)
                    ->where('user_id', $user->id)
                    ->first();
                if ($userArtist === null) {
                    $userArtist = $model->create([
                        'artist_id' => $artist->id,
                        'user_id' => $user->id,
                    ]);
                }
                foreach ($spotifyArtist->genres as $spotifyGenre) {
                    $genre = $this->genreModel
                        ->where('name', $spotifyGenre)
                        ->first();
                    if ($genre === null) {
                        $genre = $this->genreModel->create([
                            'name' => $spotifyGenre,
                        ]);
                    }
                    $artistGenre = $this->artistGenreModel
                        ->where('artist_id', $artist->id)
                        ->where('genre_id', $genre->id)
                        ->first();
                    if ($artistGenre === null) {
                        $artistGenre = $this->artistGenreModel->create([
                            'artist_id' => $artist->id,
                            'genre_id' => $genre->id,
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }
}
