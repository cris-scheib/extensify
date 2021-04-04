<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classes\Spotify\Auth;
use App\Classes\Spotify\User as SpotifyUser;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class AuthController extends Controller
{

    private $userModel;

  

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
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
        return redirect()->route('login');

    }
    public function Login()
    {
        $spotifyUser = new SpotifyUser(); 
        $data = $spotifyUser->getuser();
        $user = $this->userModel::create([
            'name' => $data->display_name,
            'email' => $data->email,
            'spotify_id' => $data->id,
            'product' => $data->product,
            'image' => empty($data->images) ? null : $data->images[0],
        ]);

         return response()->json([
            'token' => $this->jwt($user),
            'name' => $user->name,
            'id' => $user->id,
            'image' => $user->images,
        ], 200);

    }
    public function Logout()
    {
        $spotifyUser = new SpotifyUser(); 
        $data = $spotifyUser->getuser();
        $user = $this->userModel::create([
            'name' => $data->display_name,
            'email' => $data->email,
            'spotify_id' => $data->id,
            'product' => $data->product,
            'image' => empty($data->images) ? null : $data->images[0],
        ]);

         return response()->json([
            'token' => $this->jwt($user),
            'name' => $user->name,
            'id' => $user->id,
            'image' => $user->images,
        ], 200);

    }
   
}
