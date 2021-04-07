<?php

namespace App\Classes\Spotify;

use App\Classes\Spotify\Request;

class Tracks
{
    private $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function getTracks()
    {
        return $this->request->get(
            'https://api.spotify.com/v1/me/top/tracks?time_range=short_term&limit=15&offset=0'
        );
    }
}
