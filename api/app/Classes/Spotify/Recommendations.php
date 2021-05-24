<?php

namespace App\Classes\Spotify;

use App\Classes\Spotify\Request;
use App\Helpers\SettingsHelper;

class Recommendations
{
    private $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function getRecommendations($user, $seed)
    {
        return $this->request->get(
            $user,
            'https://api.spotify.com/v1/recommendations?limit=5&seed_artists=' .
                $seed
        );
    }
}
