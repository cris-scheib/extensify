<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classes\Tracks;
use App\Models\Track;

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
        $tracks = $this->trackModel->orderby('name')->with('artist.genres')->get();
        return response()->json($tracks);
    }
}
