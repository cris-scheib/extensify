<?php

namespace App\Classes\Spotify;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Exception;
class Auth
{
    private $clientId;
    private $clientSecret;
    private $apiUrl;

    public function __construct()
    {
        $this->clientId = config('services.spotify.client_id');
        $this->clientSecret = config('services.spotify.client_secret');
        $this->redirectUri = config('services.spotify.redirect_uri');
        $this->apiUrl = 'https://accounts.spotify.com/api/token';
    }

    private function generateAccessToken($code)
    {
        try {
            if(Cache::has('refreshToken')){
                $client = new Client();
                $response = $client->post($this->apiUrl, [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Accepts' => 'application/json',
                        'Authorization' => 'Basic '.base64_encode($this->clientId.':'.$this->clientSecret),
                    ],
                    'form_params' => [
                        'grant_type' => 'refresh_token',
                        'refreshToken' => Cache::get('refreshToken'),
                    ],
                ]);
            }else{
                $client = new Client();
                $response = $client->post($this->apiUrl, [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Accepts' => 'application/json',
                        'Authorization' => 'Basic '.base64_encode($this->clientId.':'.$this->clientSecret),
                    ],
                    'form_params' => [
                        'grant_type' => 'authorization_code',
                        'code' => $code,
                        'redirect_uri' => $this->redirectUri
                    ],
                ]);
            }

        } catch (RequestException $e) {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents());
            $status = $e->getCode();
            $message = $errorResponse->error;
            throw new Exception($message, $status, $errorResponse);
        }

        $body = json_decode((string) $response->getBody());

        Cache::remember('accessToken', $body->expires_in, function () use ($body) {
            return $body->access_token;
        });
        Cache::remember('refreshToken', $body->expires_in, function () use ($body) {
            return $body->refresh_token;
        });

        $body = json_decode((string) $response->getBody());
    }


    public function getAccessToken($code)
    {
        if (! Cache::has('accessToken')) {
            $this->generateAccessToken($code);
        }
         
      
        return Cache::get('accessToken');
    }
}
