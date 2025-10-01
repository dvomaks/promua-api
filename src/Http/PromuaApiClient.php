<?php

namespace Dvomaks\PromuaApi\Http;

use Dvomaks\PromuaApi\Exceptions\PromuaApiException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PromuaApiClient
{
    protected PendingRequest $client;

    public function __construct()
    {
        $loggingEnabled = Config::get('promua-api.logging.enabled', false);

        $this->client = Http::withHeaders([
            'Authorization' => 'Bearer '.Config::get('promua-api.api_token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-LANGUAGE' => Config::get('promua-api.language'),
        ])
            ->withUserAgent('Dvomaks/PromuaApi')
            ->timeout(Config::get('promua-api.timeout'))
            ->baseUrl(Config::get('promua-api.base_url'));

        if ($loggingEnabled) {
            $this->client = $this->client->beforeSending(function ($request, $options) {
                Log::info('PromUA API Request', [
                    'method' => $request->method(),
                    'url' => $request->url(),
                    'headers' => $request->headers(),
                    'body' => $request->body(),
                ]);
            });
        }
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
        $loggingEnabled = Config::get('promua-api.logging.enabled', false);

        if ($loggingEnabled) {
            Log::info('PromUA API Response', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body(),
            ]);
        }

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
