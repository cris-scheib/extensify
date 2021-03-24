<?php

namespace App\Classes;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Auth
{

    private $clientId;
    private $clientSecret;
    private $apiUrl;

    public function __construct()
    {
        $this->clientId = config('services.spotify.client_id');
        $this->clientSecret = config('services.spotify.client_secret');
        $this->apiUrl = 'https://accounts.spotify.com/api/token';
    }

    private function generateAccessToken(): void
    {
        try {
            $client = new Client();
            $response = $client->post($this->apiUrl, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accepts' => 'application/json',
                    'Authorization' => 'Basic '.base64_encode($this->clientId.':'.$this->clientSecret),
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);
        } catch (RequestException $e) {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents());
            $status = $e->getCode();
            $message = $errorResponse->error;

            throw new Exception($message, $status, $errorResponse);
        }

        $body = json_decode((string) $response->getBody());

        Cache::remember('spotifyAccessToken', $body->expires_in, function () use ($body) {
            return $body->access_token;
        });
    }

    public function getAccessToken(): string
    {
         if (! Cache::has('spotifyAccessToken')) {
             $this->generateAccessToken();
         }
         return Cache::get('spotifyAccessToken');
    }
}