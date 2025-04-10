<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GeolocationService
{
    protected Client $client;
    protected string $baseUrl = 'https://nominatim.openstreetmap.org';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 5.0,
            'headers'  => [
                'User-Agent' => 'LaravelGeolocationService/1.0', // обязательно для Nominatim
                'Accept'     => 'application/json',
            ],
        ]);
    }

    public function getLocation(float $latitude, float $longitude): ?array
    {
        try {
            $response = $this->client->get('/reverse', [
                'query' => [
                    'lat'             => $latitude,
                    'lon'             => $longitude,
                    'format'          => 'json',
                    'addressdetails'  => 1,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['address'])) {
                $address = $data['address'];

                return [
                    'city'    => $address['city']    ?? $address['town'] ?? $address['village'] ?? null,
                    'region'  => $address['state']   ?? null,
                    'country' => $address['country'] ?? null,
                    'address' => $data['display_name'] ?? null,
                ];
            }
        } catch (GuzzleException $e) {
            return null;
        }

        return null;
    }
}
