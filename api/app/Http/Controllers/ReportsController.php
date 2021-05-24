<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Track;
use App\Models\Artist;
use App\Models\History;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;


class ReportsController extends Controller
{
    private $genreModel;
    private $trackModel;
    private $artistModel;
    private $historyModel;

    public function __construct(
        Genre $genreModel,
        Track $trackModel,
        Artist $artistModel,
        History $historyModel
    ) {
        $this->genreModel = $genreModel;
        $this->trackModel = $trackModel;
        $this->artistModel = $artistModel;
        $this->historyModel = $historyModel;
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

    public function Frequency()
    {
        $labels = [];
        $frequency = [];
        for ($i = 14; $i >= 0; $i--) {
            $labels[] = substr(
                Carbon::now()
                    ->subDays($i)
                    ->format('d/m'),
                0,
                5
            );
            $frequency[] = $this->historyModel
                ->whereRaw(
                    "to_char(history.played_at, 'DD/MM/YYYY') = '" .
                        Carbon::now()
                            ->subDays($i)
                            ->format('d/m/Y') .
                        "'"
                )
                ->count();
        }
        $data = [
            'labels' => $labels,
            'frequency' => $frequency,
        ];
        return response()->json($data);
    }
}
