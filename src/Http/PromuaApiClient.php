<?php

namespace Dvomaks\PromuaApi\Http;

use Dvomaks\PromuaApi\Exceptions\PromuaApiException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class PromuaApiClient
{
    protected PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::withHeaders([
            'Authorization' => 'Bearer '.Config::get('promua-api.api_token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-LANGUAGE' => Config::get('promua-api.language'),
        ])
            ->withUserAgent('Dvomaks/PromuaApi')
            ->timeout(Config::get('promua-api.timeout'))
            ->baseUrl(Config::get('promua-api.base_url'));
    }

    public function getClient(): PendingRequest
    {
        return $this->client;
    }

    public function get(string $endpoint, array $params = []): array
    {
        $response = $this->client->get($endpoint, $params);

        return $this->handleResponse($response);
    }

    public function post(string $endpoint, array $data = [], array $headers = []): array
    {
        $response = $this->client->post($endpoint, $data);

        return $this->handleResponse($response);
    }

    public function put(string $endpoint, array $data = []): array
    {
        $response = $this->client->put($endpoint, $data);

        return $this->handleResponse($response);
    }

    public function delete(string $endpoint, array $params = []): array
    {
        $response = $this->client->delete($endpoint, $params);

        return $this->handleResponse($response);
    }

    protected function handleResponse($response): array
    {
        if (! $response->successful()) {
            throw new PromuaApiException(
                'API request failed: '.$response->body(),
                $response->status(),
                null,
                $response->json()
            );
        }

        return $response->json();
    }
}
