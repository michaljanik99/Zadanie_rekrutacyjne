<?php

namespace App\Repositories;

use GuzzleHttp\Client;

class PetRepository
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function findByStatus($status)
    {
        $response = $this->client->get('pet/findByStatus', [
            'query' => ['status' => $status]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function findById($id)
    {
        $response = $this->client->get("pet/{$id}");
        return json_decode($response->getBody()->getContents(), true);
    }

    public function add(array $data)
    {
        $response = $this->client->post('pet', [
            'json' => $data
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function update($id, array $data)
    {
        $response = $this->client->put("pet", [
            'json' => array_merge(['id' => $id], $data)
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function delete($id)
    {
        $response = $this->client->delete("pet/{$id}");
        return $response->getStatusCode() === 200;
    }
}
