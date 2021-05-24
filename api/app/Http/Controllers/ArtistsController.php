<?php

namespace App\Http\Controllers;
use App\Classes\Artists;
use App\Models\Artist;
use App\Models\UserFollowedArtist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArtistsController extends Controller
{
    private $artists;
    private $artistModel;

    public function __construct(
        Artists $artists,
        Artist $artistModel,
        UserFollowedArtist $userFollowedArtistModel
    ) {
        $this->artists = $artists;
        $this->artistModel = $artistModel;
        $this->userFollowedArtistModel = $userFollowedArtistModel;
    }

    public function GetFavorites()
    {
        $user = Cache::get('user');

        $userFavoriteArtists = $this->artistModel
            ->whereHas('userFavoriteArtist', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->count();

        if ($userFavoriteArtists == 0) {
            $this->artists->syncArtists($user);
        }
        $userFavoriteArtists = $this->artistModel
            ->whereHas('userFavoriteArtist', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderby('name')
            ->get();

        return response()->json($userFavoriteArtists);
    }
    public function GetFollowed()
    {
        $user = Cache::get('user');

        $userFollowedArtists = $this->artistModel
            ->whereHas('userFollowedArtist', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->count();

        if ($userFollowedArtists == 0) {
            $this->artists->syncArtists($user);
        }
        $userFollowedArtists = $this->artistModel
            ->whereHas('userFollowedArtist', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->selectRaw('id, name, spotify_id, image, true as follow')
            ->orderby('name')
            ->get();

        return response()->json($userFollowedArtists);
    }
    public function Unfollow(Request $request)
    {
        $user = Cache::get('user');
        $status = $this->artists->unfollow($user, $request->input('artist'));

        if ($status === null) {
            $artist = $this->artistModel
                ::where('spotify_id', $request->input('artist'))
                ->first();
            if ($artist !== null) {
                $userFollowed = $this->userFollowedArtistModel
                    ->where('artist_id', $artist->id)
                    ->where('user_id', $user->id)
                    ->first();
                if ($userFollowed !== null) {
                    $userFollowed->delete();
                }
            }
        }
        return response()->json([], $status === null ? 200 : 500);
    }
    public function Follow(Request $request)
    {
        $user = Cache::get('user');
        $status = $this->artists->follow($user, $request->input('artist'));

        if ($status === null) {
            $artist = $this->artistModel
                ->where('spotify_id', $request->input('artist'))
                ->first();
            if ($artist === null) {
                $artistSpotify = $this->artists->getArtist(
                    $user,
                    $request->input('artist')
                );
                $artist = $this->artistModel->create([
                    'name' => $artistSpotify->name,
                    'spotify_id' => $artistSpotify->id,
                    'image' => $artistSpotify->images[0]->url,
                ]);
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
            $userArtist = $this->userFollowedArtistModel
                ->where('artist_id', $artist->id)
                ->where('user_id', $user->id)
                ->first();
            if ($userArtist === null) {
                $userArtist = $this->userFollowedArtistModel->create([
                    'artist_id' => $artist->id,
                    'user_id' => $user->id,
                ]);
            }
        }
        return response()->json([], $status === null ? 200 : 500);
    }
}
