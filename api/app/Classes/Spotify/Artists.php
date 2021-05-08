<?php

namespace App\Classes\Spotify;

use App\Classes\Spotify\Request;
use App\Helpers\SettingsHelper;

class Artists
{
    private $request;

    public function __construct()
    {
        $this->request = new Request();
    }
    public function getFavoriteArtists($user)
    {
        $term = SettingsHelper::getTerm('artists_term', $user);
        return $this->request->get(
            $user,
            'https://api.spotify.com/v1/me/top/artists?time_range=' .
                $term .
                '&limit=15&offset=0'
        );
    }
    public function getFollowedArtists($user)
    {
        return $this->request->get(
            $user,
            'https://api.spotify.com/v1/me/following?type=artist&limit=1'
        );
    }
}
