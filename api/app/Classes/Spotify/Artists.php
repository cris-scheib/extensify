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

    public function getArtist($user,$artist)
    {
        return $this->request->get(
            $user,
            'https://api.spotify.com/v1/artists/' . $artist
        );
    }
    public function getFavorite($user)
    {
        $term = SettingsHelper::getTerm('artists_term', $user);
        return $this->request->get(
            $user,
            'https://api.spotify.com/v1/me/top/artists?time_range=' .
                $term .
                '&limit=15&offset=0'
        );
    }
    public function getFollowed($user, $next = null)
    {
        return $this->request->get(
            $user,
            isset($next)
                ? $next
                : 'https://api.spotify.com/v1/me/following?type=artist&limit=10'
        );
    }
    public function unfollow($user, $artist)
    {
        return $this->request->delete(
            $user,
            'https://api.spotify.com/v1/me/following?type=artist&ids=' . $artist
        );
    }
    public function follow($user, $artist)
    {
        return $this->request->put(
            $user,
            'https://api.spotify.com/v1/me/following?type=artist&ids=' . $artist
        );
    }
}
