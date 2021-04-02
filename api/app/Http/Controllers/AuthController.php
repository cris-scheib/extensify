<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classes\Spotify\Auth;
use App\Classes\Spotify\User as SpotifyUser;
use App\Models\User;

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
        return redirect()->route('login');

    }
    public function Login()
    {
        $user = new SpotifyUser(); 
        $data = $user->getuser();
        $me = $this->userModel::create([
            'name' => $data->display_name,
            'email' => $data->email,
            'spotify_id' => $data->id,
            'product' => $data->product,
            'image' => empty($data->images) ? null : $data->images[0],
        ]);

        
    }
   
}
