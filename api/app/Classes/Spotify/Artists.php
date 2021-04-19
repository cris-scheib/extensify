<?php

namespace App\Classes\Spotify;

use App\Classes\Spotify\Request;

class Artists
{
    private $request;

    public function __construct()
    {
        $this->request = new Request();
    }
    public function getArtists($user)
    {

        return $this->request->get($user,
            'https://api.spotify.com/v1/me/top/artists?time_range=medium_term&limit=15&offset=0'
        );
    }
}
