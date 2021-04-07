<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classes\Spotify\Auth;
use App\Classes\Spotify\User as SpotifyUser;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AuthController extends Controller
{
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    protected function jwt(User $user)
    {
        $payload = [
            'iss' => 'lumen-jwt', // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60 * 60, // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
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
                'expiration_token' => Carbon::now(),
            ]);
        } else {
            $user->update([
                'name' => $data->display_name,
                'product' => $data->product,
                'image' => empty($data->images) ? null : $data->images[0],
                'token' => Cache::get('accessToken'),
                'refresh_token' => Cache::get('refreshToken'),
                'expiration_token' => Carbon::now(),
            ]);
        }

        return response()->json(
            [
                'token' => $this->jwt($user),
                'name' => $user->name,
                'id' => $user->spotify_id,
                'image' => $user->images,
                'product' => $user->product,
                
            ],
            200
        );
    }

}
