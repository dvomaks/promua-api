<?php

namespace Dvomaks\PromuaApi\Http;

use Dvomaks\PromuaApi\Exceptions\PromuaApiException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * PromuaApiClient is a wrapper for making HTTP requests to the PromUA API.
 * It handles authentication, headers, timeout, and base URL configuration.
 * It also provides logging capabilities for requests and responses.
 */
class PromuaApiClient
{
    protected PendingRequest $client;

    /**
     * Initializes the HTTP client with authentication headers, base URL, and timeout.
     * If logging is enabled, it will log requests and responses.
     */
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
            $this->client = $this->client->beforeSending(function ($request) {
                $logData = [
                    'method' => $request->method(),
                    'url' => $request->url(),
                    'headers' => $request->headers(),
                    'body' => $request->body(),
                ];
                Log::info('PromUA API Request: '.json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            });
        }
    }

    /**
     * Sends a GET request to the specified endpoint with optional parameters.
     *
     * @param  string  $endpoint  The API endpoint to send the request to
     * @param  array  $params  Optional query parameters
     * @return array The response data as an array
     *
     * @throws PromuaApiException
     * @throws ConnectionException
     */
    public function get(string $endpoint, array $params = []): array
    {
        $response = $this->client->get($endpoint, $params);

        return $this->handleResponse($response);
    }

    /**
     * Sends a POST request to the specified endpoint with optional data and headers.
     *
     * @param  string  $endpoint  The API endpoint to send the request to
     * @param  array  $data  Optional request body data
     * @return array The response data as an array
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function post(string $endpoint, array $data = []): array
    {
        $response = $this->client->post($endpoint, $data);

        return $this->handleResponse($response);
    }

    /**
     * Sends a PUT request to the specified endpoint with optional data.
     *
     * @param  string  $endpoint  The API endpoint to send the request to
     * @param  array  $data  Optional request body data
     * @return array The response data as an array
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function put(string $endpoint, array $data = []): array
    {
        $response = $this->client->put($endpoint, $data);

        return $this->handleResponse($response);
    }

    /**
     * Sends a DELETE request to the specified endpoint with optional parameters.
     *
     * @param  string  $endpoint  The API endpoint to send the request to
     * @param  array  $params  Optional query parameters
     * @return array The response data as an array
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function delete(string $endpoint, array $params = []): array
    {
        $response = $this->client->delete($endpoint, $params);

        return $this->handleResponse($response);
    }

    /**
     * Handles the API response, including logging and error handling.
     * If the response is not successful, it throws a PromuaApiException.
     *
     * @param  mixed  $response  The response HTTP response object
     * @return array The response data as an array
     *
     * @throws PromuaApiException If the response status indicates an error
     */
    protected function handleResponse(mixed $response): array
    {
        $loggingEnabled = Config::get('promua-api.logging.enabled', false);

        if ($loggingEnabled) {
            $logData = [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->json(),
            ];
            Log::info('PromUA API Response: '.json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
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
