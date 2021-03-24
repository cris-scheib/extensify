<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classes\Auth;

class AuthController extends Controller
{

    public function __construct()
    {
       
    }

    public function Authenticate(Request $request)
    {
        $auth = new Auth();
        $code = $request->input('code'); 
        $state = $request->input('state');   
        $token = $auth->getAccessToken();    
        dd($code, $state, $token);
    }

    public function Keys()
    {
        $callback = app()->environment('local') ? config('app.url') .':8000' : config('app.url') ;
        $data = [
            'scope' => 'user-read-email user-read-recently-played 
                        user-read-playback-state user-top-read 
                        user-read-currently-playing user-follow-read 
                        user-library-read',
            'client_id' => config('services.spotify.client_id'),
            'callback' =>   $callback . '/api/auth', 
        ];
        return response($data);
        
        
    }
}
