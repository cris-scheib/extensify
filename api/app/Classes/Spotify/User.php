<?php

namespace App\Classes\Spotify;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class User
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
    public function getUser()
    {
        try {
            $client = new Client();
            $response = $client->get('https://api.spotify.com/v1/me', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accepts' => 'application/json',
                    'Authorization' => 'Bearer '. Cache::get('accessToken'),
                ],
            ]);
        } catch (RequestException $e) {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents());
            $status = $e->getCode();
            $message = $errorResponse->error;
        }

        return json_decode((string) $response->getBody());
    }
}