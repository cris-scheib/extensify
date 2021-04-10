<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classes\Spotify\Auth;
use App\Classes\Spotify\User as SpotifyUser;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AuthController extends Controller
{
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function Authenticate(Request $request)
    {
        $auth = new Auth();
        $code = $request->input('code');
        $token = $auth->getAccessToken($code);

        $spotifyUser = new SpotifyUser();
        $data = $spotifyUser->getuser();

        $user = $this->userModel::where('spotify_id', $data->id)->first();
        if ($user === null) {
            $user = $this->userModel->create([
                'name' => $data->display_name,
                'email' => $data->email,
                'spotify_id' => $data->id,
                'product' => $data->product,
                'image' => empty($data->images) ? null : $data->images[0],
                'token' => Cache::get('accessToken'),
                'refresh_token' => Cache::get('refreshToken'),
                'expiration_token' => Carbon::now()->addHour(),
            ]);
        } else {
            $user->update([
                'name' => $data->display_name,
                'product' => $data->product,
                'image' => empty($data->images) ? null : $data->images[0],
                'token' => Cache::get('accessToken'),
                'refresh_token' => Cache::get('refreshToken'),
                'expiration_token' => Carbon::now()->addHour(),
            ]);
        }
        Cache::remember('user', 3600, function () use ($user) {
            return $user;
        });

        return response()->json(
            [
                'user' => $user->id,
                'name' => $user->name,
                'id' => $user->spotify_id,
                'image' => $user->images,
                'product' => $user->product,
            ],
            200
        );
    }
}
