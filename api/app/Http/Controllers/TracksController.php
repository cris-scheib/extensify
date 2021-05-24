<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classes\Tracks;
use App\Models\Track;
use Illuminate\Support\Facades\Cache;

class TracksController extends Controller
{
    private $tracks;
    private $trackModel;

    public function __construct(Tracks $tracks, Track $trackModel)
    {
        $this->trackModel = $trackModel;
        $this->tracks = $tracks;
    }

    public function GetFavorites()
    {
        $user = Cache::get('user');

        $userFavoriteTracks = $this->trackModel
            ->whereHas('userFavoriteTracks', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->count();
        if ($userFavoriteTracks == 0) {
            $this->tracks->syncFavorite($user);
        }
        $userFavoriteTracks = $this->trackModel
            ->with('artist.genres')
            ->whereHas('userFavoriteTracks', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();
        return response()->json($userFavoriteTracks);
    }

}
