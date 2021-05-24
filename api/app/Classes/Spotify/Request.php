<?php

namespace App\Classes\Spotify;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use App\Classes\Spotify\Auth;
use Carbon\Carbon;

class Request
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }
    public function get($user, $url)
    {
        $response = $this->client->get($url, [
            'headers' => $this->header($user),
        ]);
        return json_decode((string) $response->getBody());
    }

    public function delete($user, $url)
    {
        $response = $this->client->delete($url, [
            'headers' => $this->header($user),
        ]);
        return json_decode((string) $response->getBody());
    }
    public function put($user, $url)
    {
        $response = $this->client->put($url, [
            'headers' => $this->header($user),
        ]);
        return json_decode((string) $response->getBody());
    }
    public function post($user, $url)
    {
        $response = $this->client->post($url, [
            'headers' => $this->header($user),
        ]);
        return json_decode((string) $response->getBody());
    }

    private function header($user)
    {
        return [
            'Content-Type' => 'application/json',
            'Accepts' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token($user),
        ];
    }
    private function token($user)
    {
        if (
            $user->expiration_token > Carbon::now() &&
            $user->expiration_token < Carbon::now()->addMinutes(5)
        ) {
            $auth = new Auth();
            $auth->RefreshToken($user);
        }
        return $user->token;
    }
}
