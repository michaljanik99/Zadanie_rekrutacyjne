<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PetRepository
{
    private Client $client;
    private string $key = "test";

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @throws \Exception
     */
    public function findByStatus(string $status): array|object
    {
        try {
            $response = $this->client->get('pet/findByStatus', [
                'query' => ['status' => $status]
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception('Error fetching pet data', 0, $e);
        }
    }

    /**
     * @throws \Exception
     */
    public function findById(int $id): array|object
    {
        try {
            $response = $this->client->get("pet/$id");
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception('Error fetching pet data', 0, $e);
        }
    }

    /**
     * @throws \Exception
     */
    public function add(array $data): array|object
    {
        try {
            $response = $this->client->post('pet', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getKey(),
                    'Content-Type' => 'application/json',
                ],
                'json' => $data
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception('Error fetching pet data', 0, $e);
        }
    }

    /**
     * @throws \Exception
     */
    public function update(int $id, array $data): array|object
    {
        try {
            $response = $this->client->put("pet", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getKey(),
                    'Content-Type' => 'application/json',
                ],
                'json' => array_merge(['id' => $id], $data)
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception('Error fetching pet data', 0, $e);
        }
    }

    /**
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        try {
            $response = $this->client->delete("pet/$id");
            return $response->getStatusCode() === 200;
        } catch (GuzzleException $e) {
            throw new \Exception('Error fetching pet data', 0, $e);
        }
    }
}
