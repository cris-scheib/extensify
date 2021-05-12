<?php

namespace App\Http\Controllers;
use App\Classes\Artists;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArtistsController extends Controller
{
    private $artists;
    private $artistModel;

    public function __construct(Artists $artists, Artist $artistModel)
    {
        $this->artists = $artists;
        $this->artistModel = $artistModel;
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
    public function Unfollow(Artist $artists)
    {
        $user = Cache::get('user');

        $this->artists->unfollow($user, $artists);   
    }
}
