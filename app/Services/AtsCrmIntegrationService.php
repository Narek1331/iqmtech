<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class AtsCrmIntegrationService
{
    protected Client $client;
    protected string $baseUrl;
    protected ?string $accessToken;
    protected ?string $refreshToken;

    public function __construct()
    {
        $this->baseUrl = 'https://ats2.tele2.ru/crm/openapi';
        $this->accessToken = 'eyJhbGciOiJIUzUxMiJ9.eyJVc2VyRGV0YWlsc0ltcGwiOnsiY29tcGFueUlkIjoxOTk1MiwidXNlcklkIjo0MzgyMSwibG9naW4iOiI3OTUzNzA2MjU3MyJ9LCJzdWIiOiJBQ0NFU1NfT1BFTkFQSV9UT0tFTiIsImV4cCI6MTc0NDk3NDEwM30.4ZNjXgdafzZsPg6M8Spa7-jiWwkBqzrK0rKahelEWXAwOeLPEbkOmLrxrjwCa5pL_rDH6ipJRKpHWudiyRTZ5g';
        $this->refreshToken = 'eyJhbGciOiJIUzUxMiJ9.eyJVc2VyRGV0YWlsc0ltcGwiOnsiY29tcGFueUlkIjoxOTk1MiwidXNlcklkIjo0MzgyMSwibG9naW4iOiI3OTUzNzA2MjU3MyJ9LCJzdWIiOiJSRUZSRVNIX09QRU5BUElfVE9LRU4iLCJleHAiOjE3NDU0OTI1MDN9.SkNVz1gMHlGxzM83AVUldBz6pKZMaJDtN2zgJ5GR1OY8qr7TRYCP5WWjb8EejKXFnVs8fRINf5ehrBtnPU5EwQ';
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'verify' => storage_path('/certs/Root-R3.crt'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Sets the Access Token.
     *
     * @param string $accessToken
     * @return $this
     */
    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * Sets the Refresh Token.
     *
     * @param string $refreshToken
     * @return $this
     */
    public function setRefreshToken(string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;
        return $this;
    }

    /**
     * Updates the Access Token using the Refresh Token.
     *
     * @return array|null
     * @throws GuzzleException
     */
    public function updateToken(): ?array
    {
        if (!$this->refreshToken) {
            Log::error('Refresh token is not set.');
            return null;
        }

        try {
            $response = $this->client->put('/authorization/refresh/token', [
                'headers' => [
                    'Authorization' => $this->refreshToken,
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody(), true);

            if ($statusCode === 200 && isset($body['accessToken'], $body['refreshToken'])) {
                $this->accessToken = $body['accessToken'];
                $this->refreshToken = $body['refreshToken'];
                return $body;
            } else {
                Log::error('Failed to update token.', ['status_code' => $statusCode, 'body' => $body]);
                return null;
            }
        } catch (GuzzleException $e) {
            Log::error('Error updating token: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gets the authorization headers.
     *
     * @return array
     */
    protected function getAuthorizationHeaders(): array
    {
        if (!$this->accessToken) {
            Log::warning('Access token is not set. API calls might fail.');
        }
        return [
            'Authorization' => $this->accessToken ?? '',
        ];
    }

    /**
     * Gets information about current calls.
     *
     * @return array|null
     * @throws GuzzleException
     */
    public function getCurrentCalls(): ?array
    {
        try {
            $response = $this->client->get('/monitoring/calls', [
                'headers' => $this->getAuthorizationHeaders(),
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            Log::error('Error getting current calls: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gets the list of subscribers in the queue.
     *
     * @return array|null
     * @throws GuzzleException
     */
    public function getPendingCalls(): ?array
    {
        try {
            $response = $this->client->get('/monitoring/calls/pending', [
                'headers' => $this->getAuthorizationHeaders(),
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            Log::error('Error getting pending calls: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gets the list of company employees.
     *
     * @return array|null
     * @throws GuzzleException
     */
    public function getEmployees(): ?array
    {
        try {
            $response = $this->client->get('/employees', [
                'headers' => $this->getAuthorizationHeaders(),
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            Log::error('Error getting employees: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Initiates a call via the PBX (Click 2 Call).
     *
     * @param string $destination The client's phone number.
     * @param string $source The employee's phone number.
     * @return bool
     * @throws GuzzleException
     */
    public function clickToCall(string $destination, string $source): bool
    {
        try {
            $response = $this->client->post("/call/outgoing?destination={$destination}&source={$source}", [
                'headers' => $this->getAuthorizationHeaders(),
            ]);

            return $response->getStatusCode() === 200;
        } catch (GuzzleException $e) {
            Log::error('Error initiating click to call: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gets general call statistics for a given period.
     *
     * @param string $start Start date and time (ISO format with offset).
     * @param string $end End date and time (ISO format with offset).
     * @param string|null $subscriberNumber Optional PBX subscriber number (7XXXXXXXXXX format).
     * @return array|null
     * @throws GuzzleException
     */
    public function getCommonStatistics(string $start, string $end, ?string $subscriberNumber = null): ?array
    {
        $query = [
            'start' => $start,
            'end' => $end,
        ];
        if ($subscriberNumber) {
            $query['subscriberNumber'] = $subscriberNumber;
        }

        try {
            $response = $this->client->get('/statistics/common', [
                'headers' => $this->getAuthorizationHeaders(),
                'query' => $query,
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            Log::error('Error getting common statistics: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gets call statistics for a specific number within a given period.
     *
     * @param string $start Start date and time (ISO format with offset).
     * @param string $end End date and time (ISO format with offset).
     * @param string $number The phone number to get statistics for (7XXXXXXXXXX format).
     * @return array|null
     * @throws GuzzleException
     */
    public function getJournalStatistics(string $start, string $end, string $number): ?array
    {
        try {
            $response = $this->client->get('/statistics/journal', [
                'headers' => $this->getAuthorizationHeaders(),
                'query' => [
                    'start' => $start,
                    'end' => $end,
                    'number' => $number,
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            Log::error('Error getting journal statistics: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gets a list of call recordings based on specified parameters.
     *
     * @param string $start Start date and time (ISO OFFSET DATE TIME format).
     * @param string $end End date and time (ISO OFFSET DATE TIME format).
     * @param string|null $caller Optional caller number.
     * @param string|null $callee Optional callee number.
     * @param bool|null $isRecorded Optional filter for recorded calls.
     * @param int|null $page Optional page number (default: 0).
     * @param int|null $size Optional number of records per page (default: 10).
     * @param string|null $sort Optional sorting rules (e.g., 'date,DESC').
     * @return array|null
     * @throws GuzzleException
     */
    public function getCallRecordList(
        string $start,
        string $end,
        ?string $caller = null,
        ?string $callee = null,
        ?bool $isRecorded = null,
        ?int $page = null,
        ?int $size = null,
        ?string $sort = null
    ): ?array {
        $query = [
            'start' => $start,
            'end' => $end,
        ];
        if ($caller) $query['caller'] = $caller;
        if ($callee) $query['callee'] = $callee;
        if ($isRecorded !== null) $query['is_recorded'] = $isRecorded ? 'true' : 'false';
        if ($page !== null) $query['page'] = $page;
        if ($size !== null) $query['size'] = $size;
        if ($sort) $query['sort'] = $sort;

        try {
            $response = $this->client->get('/call-records/info', [
                'headers' => $this->getAuthorizationHeaders(),
                'query' => $query,
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            Log::error('Error getting call record list: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gets a call recording file.
     *
     * @param string $filename The name of the recording file.
     * @return ?string The content of the MP3 file, or null on failure.
     * @throws GuzzleException
     */
    public function getCallRecordingFile(string $filename): ?string
    {
        try {
            $response = $this->client->get('/call-records/file', [
                'headers' => $this->getAuthorizationHeaders(),
                'query' => [
                    'filename' => $filename,
                ],
                'stream' => true, // Important for downloading files
            ]);

            if ($response->getStatusCode() === 200) {
                return $response->getBody()->getContents();
            } else {
                Log::error('Failed to get call recording file.', ['status_code' => $response->getStatusCode()]);
                return null;
            }
        } catch (GuzzleException $e) {
            Log::error('Error getting call recording file: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gets the transcribed text of a call recording.
     *
     * @param string $filename The name of the recording file.
     * @return array|null
     * @throws GuzzleException
     */
    public function getCallRecordingTranscription(string $filename): ?array
    {
        try {
            $response = $this->client->get('/call-records/file/stt', [
                'headers' => $this->getAuthorizationHeaders(),
                'query' => [
                    'filename' => $filename,
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            Log::error('Error getting call recording transcription: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gets a list of personal managers.
     *
     * @return array|null
     * @throws GuzzleException
     */
    public function getManagers(): ?array
    {
        try {
            $response = $this->client->get('/managers', [
                'headers' => $this->getAuthorizationHeaders(),
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            Log::error('Error getting managers: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gets data for a specific manager by ID.
     *
     * @param int $id The ID of the manager.
     * @return array|null
     * @throws GuzzleException
     */
    public function getManagerById(int $id): ?array
    {
        try {
            $response = $this->client->get("/managers/{$id}", [
                'headers' => $this->getAuthorizationHeaders(),
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            Log::error("Error getting manager with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Creates a new manager.
     *
     * @param array $managerData The manager data as a JSON object.
     * @return string|null 'SUCCESS' or an error message.
     * @throws GuzzleException
     */
    public function createManager(array $managerData): ?string
    {
        try {
            $response = $this->client->post('/managers', [
                'headers' => $this->getAuthorizationHeaders(),
                'json' => $managerData,
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            if ($statusCode === 200) {
                return trim($body, '"');
            } else {
                Log::error('Failed to create manager.', ['status_code' => $statusCode, 'body' => $body]);
                return trim($body, '"');
            }
        } catch (GuzzleException $e) {
            Log::error('Error creating manager: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Updates an existing manager.
     *
     * @param array $managerData The manager data to update, including the 'id'.
     * @return string|null 'SUCCESS' or an error message.
     * @throws GuzzleException
     */
    public function updateManager(array $managerData): ?string
    {
        try {
            $response = $this->client->put('/managers', [
                'headers' => $this->getAuthorizationHeaders(),
                'json' => $managerData,
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            if ($statusCode === 200) {
                return trim($body, '"');
            } elseif ($statusCode === 404) {
                return 'HTTP 404 – если поле "id" пропущено или объекта с таким ID не существует.';
            } else {
                Log::error('Failed to update manager.', ['status_code' => $statusCode, 'body' => $body]);
                return trim($body, '"');
            }
        } catch (GuzzleException $e) {
            Log::error('Error updating manager: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Deletes a manager by ID.
     *
     * @param int $id The ID of the manager to delete.
     * @return bool True on success, false otherwise.
     * @throws GuzzleException
     */
    public function deleteManager(int $id): bool
    {
        try {
            $response = $this->client->delete("/managers/{$id}", [
                'headers' => $this->getAuthorizationHeaders(),
            ]);

            return $response->getStatusCode() === 200;
        } catch (GuzzleException $e) {
            if ($e->getResponse() && $e->getResponse()->getStatusCode() === 404) {
                return false; // Object with such ID does not exist
            }
            Log::error("Error deleting manager with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Adds a number to the blacklist.
     *
     * @param string $msisdn The phone number to add (7XXXXXXXXXX format).
     * @return string|null 'SUCCESS' or 'DUPLICATE_BLACK_LIST_NUMBER'.
     * @throws GuzzleException
     */
    public function addToBlacklist(string $msisdn): ?string
    {
        try {
            $response = $this->client->post('/blacklist', [
                'headers' => array_merge($this->getAuthorizationHeaders(), ['Content-Type' => 'text/html']),
                'body' => $msisdn,
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            if ($statusCode === 200) {
                return trim($body, '"');
            } else {
                Log::error('Failed to add number to blacklist.', ['status_code' => $statusCode, 'body' => $body]);
                return trim($body, '"');
            }
        } catch (GuzzleException $e) {
            Log::error('Error adding number to blacklist: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Deletes a number from the blacklist by MSISDN.
     *
     * @param string $msisdn The phone number to remove (7XXXXXXXXXX format).
     * @return bool True on success, false otherwise.
     * @throws GuzzleException
     */
    public function deleteFromBlacklist(string $msisdn): bool
    {
        try {
            $response = $this->client->delete("/blacklist/by-msisdn/{$msisdn}", [
                'headers' => $this->getAuthorizationHeaders(),
            ]);

            return $response->getStatusCode() === 200;
        } catch (GuzzleException $e) {
            Log::error("Error deleting number {$msisdn} from blacklist: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Deletes all numbers from the blacklist.
     *
     * @return bool True on success, false otherwise.
     * @throws GuzzleException
     */
    public function clearBlacklist(): bool
    {
        try {
            $response = $this->client->delete('/blacklist/all', [
                'headers' => $this->getAuthorizationHeaders(),
            ]);

            return $response->getStatusCode() === 200;
        } catch (GuzzleException $e) {
            Log::error('Error clearing the blacklist: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gets the entire blacklist.
     *
     * @return array|null
     * @throws GuzzleException
     */
    public function getBlacklist(): ?array
    {
        try {
            $response = $this->client->get('/blacklist', [
                'headers' => $this->getAuthorizationHeaders(),
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            Log::error('Error getting the blacklist: ' . $e->getMessage());
            throw $e;
        }
    }
}
