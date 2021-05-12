<?php

namespace App\Classes\Spotify;

use App\Classes\Spotify\Request;
use App\Helpers\SettingsHelper;

class History
{
    private $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function getHistory($user)
    {
        return $this->request->get(
            $user,
            'https://api.spotify.com/v1/me/player/recently-played?limit=50'
        );
    }
}
