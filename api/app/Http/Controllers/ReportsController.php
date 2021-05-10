<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Track;
use App\Models\Artist;
use Illuminate\Support\Facades\Cache;

class ReportsController extends Controller
{
    private $genreModel;
    private $trackModel;
    private $artistModel;

    public function __construct(
        Genre $genreModel,
        Track $trackModel,
        Artist $artistModel
    ) {
        $this->genreModel = $genreModel;
        $this->trackModel = $trackModel;
        $this->artistModel = $artistModel;
    }

    public function FavoriteGenres()
    {
        $genres = $this->genreModel->select('id', 'name')->get();

        $favorites = [];
        foreach ($genres as $key => $genre) {
            $artists = $this->artistModel
                ->whereHas('artistGenre', function ($query) use ($genre) {
                    $query->whereHas('genre', function ($subQuery) use (
                        $genre
                    ) {
                        $subQuery->where('genre_id', $genre->id);
                    });
                })
                ->count();
            $tracks = $this->trackModel
                ->whereHas('artist', function ($query) use ($genre) {
                    $query->whereHas('artistGenre', function ($subQuery) use (
                        $genre
                    ) {
                        $subQuery->whereHas('genre', function (
                            $subSubQuery
                        ) use ($genre) {
                            $subSubQuery->where('genre_id', $genre->id);
                        });
                    });
                })
                ->count();
            $favorites[$key] = [
                'name' => $genre->name,
                'tracks' => $tracks,
                'artists' => $artists,
                'total' => $tracks + $artists,
            ];
        }

        usort($favorites, function ($x, $y) {
            return -($x['total'] - $y['total']);
        });
        $favorites = array_slice($favorites, 0, 6);

        $data = [
            'genre' => array_column($favorites, 'name'),
            'artists' => array_column($favorites, 'artists'),
            'tracks' => array_column($favorites, 'tracks'),
        ];
        return response()->json($data);
    }
}
