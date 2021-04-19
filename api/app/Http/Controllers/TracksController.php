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

    public function Get()
    {
        $user = Cache::get('user');

        $userTracks = $this->trackModel
            ->whereHas('userTrack', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->count();

        if ($userTracks == 0) {
            $this->tracks->syncTracks($user);
        }
        $userTracks = $this->trackModel
            ->with('artist.genres')
            ->whereHas('userTrack', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();
        return response()->json($userTracks);
    }
}
