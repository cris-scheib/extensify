<?php

namespace App\Classes\Spotify;

use App\Classes\Spotify\Request;
use App\Helpers\SettingsHelper;

class Tracks
{
    private $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function getFavoriteTracks($user)
    {
        $term = SettingsHelper::getTerm('tracks_term', $user);
        return $this->request->get(
            $user,
            'https://api.spotify.com/v1/me/top/tracks?time_range=' .
                $term .
                '&limit=15&offset=0'
        );
    }
}
