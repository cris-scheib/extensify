<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classes\Recommendations;
use App\Models\Recommendation as RecommendationModel;
use App\Models\Artist;
use Illuminate\Support\Facades\Cache;

class RecommendationsController extends Controller
{
    private $recommendations;
    private $recommendationModel;
    private $artistModel;

    public function __construct(
        Recommendations $recommendations,
        RecommendationModel $recommendationModel,
        Artist $artistModel
    ) {
        $this->artistModel = $artistModel;
        $this->recommendationModel = $recommendationModel;
        $this->recommendations = $recommendations;
    }

    public function Get()
    {
        $user = Cache::get('user');
        $user = Cache::get('user');

        $userRecommendations = $this->recommendationModel
            ->where('user_id', $user->id)
            ->count();

        if ($userRecommendations == 0) {
            $this->recommendations->syncRecommendations($user);
        }
        $userRecommendations = $this->artistModel
            ->whereHas('userRecommendations', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->selectRaw('id, name, spotify_id, image, false as follow')
            ->orderby('name')
            ->get();

        return response()->json($userRecommendations);
    }
}
