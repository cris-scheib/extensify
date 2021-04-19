<?php

namespace App\Classes;
use App\Models\ArtistGenre;
use App\Models\UserArtist;
use App\Models\Artist;
use App\Models\Genre;
use App\Classes\Spotify\Artists as SpotifyArtists;
use Illuminate\Support\Facades\DB;

class Artists
{
    private $artistModel;
    private $genreModel;
    private $artistGenreModel;

    public function __construct()
    {
        $this->artistModel = new Artist();
        $this->genreModel = new Genre();
        $this->artistGenreModel = new ArtistGenre();
        $this->userArtistModel = new UserArtist();
    }

    public function syncArtists($user)
    {
        $apotifyArtists = new SpotifyArtists();
        $data = $apotifyArtists->getArtists($user);

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
                $userArtist = $this->userArtistModel
                    ->where('artist_id', $artist->id)
                    ->where('user_id', $user->id)
                    ->first();
                if ($userArtist === null) {
                    $userArtist = $this->userArtistModel->create([
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
