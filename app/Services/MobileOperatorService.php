<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MobileOperatorService
{
    protected Client $client;
    protected string $baseUrl;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 5.0,
        ]);

        $this->baseUrl = 'https://ipwho.is/';
    }

    /**
     * Get mobile operator information by IP address
     *
     * @param string $ip
     * @return array|null
     */
    public function getOperator(string $ip): ?array
    {
        try {
            $response = $this->client->get("{$this->baseUrl}{$ip}");
            $data = json_decode($response->getBody(), true);

            if (!isset($data['success']) || $data['success'] !== true) {
                return null;
            }

            return [
                'ip'     => $data['ip'] ?? null,
                'isp'    => $data['connection']['isp'] ?? null,
                'org'    => $data['connection']['org'] ?? null,
                'type'   => $data['connection']['type'] ?? null,
                'country' => $data['country'] ?? null,
                'region' => $data['region'] ?? null,
                'city'   => $data['city'] ?? null,
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }
}
