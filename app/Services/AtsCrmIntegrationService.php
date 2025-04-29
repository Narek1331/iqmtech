<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

class AtsCrmIntegrationService
{
    private $client;
    private $accessToken;
    private $refreshToken;

    public function __construct()
    {
        $this->client = new Client();
        $this->accessToken = 'eyJhbGciOiJIUzUxMiJ9.eyJVc2VyRGV0YWlsc0ltcGwiOnsiY29tcGFueUlkIjoxOTk1MiwidXNlcklkIjo0MzgyMSwibG9naW4iOiI3OTUzNzA2MjU3MyJ9LCJzdWIiOiJBQ0NFU1NfT1BFTkFQSV9UT0tFTiIsImV4cCI6MTc0NTY2OTMyM30.3SIYxREo-0vTjz1TdjvKRdyJccaImX5SrlpIlyKWQwXmXrESr2A6ceRRo4og9Gl5Nh36Y9OaFKFpbUfEcpv_Aw';
        $this->refreshToken = 'eyJhbGciOiJIUzUxMiJ9.eyJVc2VyRGV0YWlsc0ltcGwiOnsiY29tcGFueUlkIjoxOTk1MiwidXNlcklkIjo0MzgyMSwibG9naW4iOiI3OTUzNzA2MjU3MyJ9LCJzdWIiOiJSRUZSRVNIX09QRU5BUElfVE9LRU4iLCJleHAiOjE3NDYxODc3MjN9.Nx2tA6x4q9hT2GweDX6hZZ_7KxajFVq5_rbId7vzX-aphIzGGqQUC934hai5N7_NJjfwDwGTb1d1dZ7U52nwvA';
    }

    public function getCalls()
    {
        try {
            $response = $this->client->request('GET', 'https://ats2.tele2.ru/crm/openapi/monitoring/calls', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                ],
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function refreshAccessToken()
    {
        try {
            $response = $this->client->request('PUT', 'https://ats2.tele2.ru/crm/openapi/authorization/refresh/token', [
                'headers' => [
                    'Authorization' => $this->refreshToken,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ]);
            // $data = json_decode($response->getBody()->getContents(), true);
            dd($response->getStatusCode());


            if (isset($data['access_token'])) {
                // $this->accessToken = $data['access_token'];
            }
        } catch (RequestException $e) {
            dd($e);
        }
    }

}
