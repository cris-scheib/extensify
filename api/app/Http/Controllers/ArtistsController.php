<?php

namespace App\Http\Controllers;
use App\Classes\Artists;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArtistsController extends Controller
{
    private $artists;
    private $artistModel;

    public function __construct(Artists $artists, Artist $artistModel)
    {
        $this->artists = $artists;
        $this->artistModel = $artistModel;
    }

    public function Get()
    {
        $user = Cache::get('user');

        $userArtists = $this->artistModel
            ->whereHas('userArtist', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->count();

        if ($userArtists == 0) {
            $this->artists->syncArtists($user);
        }
        $userArtists = $this->artistModel
            ->whereHas('userArtist', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderby('name')
            ->get();

        return response()->json($userArtists);
    }
}
