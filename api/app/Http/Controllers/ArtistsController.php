<?php

namespace App\Http\Controllers;
use App\Classes\Artists;
use App\Models\Artist;

class ArtistsController extends Controller
{
    private $artists;
    private $artistModel;

    public function __construct(Artists $artists, Artist $artistModel)
    {
        $this->artists = $artists;
        $this->artistModel = $artistModel;
    }

    public function Artists()
    {
        $artists = $this->artistModel->orderby('name')->get();
        return response()->json($artists);
    }
}
