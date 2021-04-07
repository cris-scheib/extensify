<?php

namespace App\Classes\Spotify;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

class Request
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }
    public function get($url)
    {
        try {
            $response = $this->client->get($url, [
                'headers' => $this->header(),
            ]);
        } catch (RequestException $e) {
            $errorResponse = json_decode(
                $e
                    ->getResponse()
                    ->getBody()
                    ->getContents()
            );
            $status = $e->getCode();
            $message = $errorResponse->error;
        }

        return json_decode((string) $response->getBody());
    }

    private function header()
    {
        return [
            'Content-Type' => 'application/json',
            'Accepts' => 'application/json',
            'Authorization' => 'Bearer ' . Cache::get('accessToken'),
        ];
    }
}
