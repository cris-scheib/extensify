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

    public function Tracks()
    {
        $user = Cache::get('user');
        $tracks = $this->trackModel
            ->with('artist.genres')
            ->whereHas('userTrack', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();
        return response()->json($tracks);
    }
}
