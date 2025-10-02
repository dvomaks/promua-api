<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Dto\ClientDto;
use Dvomaks\PromuaApi\Exceptions\PromuaApiException;
use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Illuminate\Http\Client\ConnectionException;

/**
 * ClientsService provides methods to interact with client functionality of the Promua API.
 * It allows retrieving clients list and getting a specific client by ID.
 */
class ClientsService
{
    /**
     * ClientsService constructor.
     *
     * @param  PromuaApiClient  $client  The API client used to make requests to the Promua API
     */
    public function __construct(protected PromuaApiClient $client) {}

    /**
     * Get a list of clients
     *
     * @param  int|null  $limit  Limit the number of clients in the response
     * @param  int|null  $lastId  Limit the selection of clients with identifiers not higher than the specified one
     * @param  string|null  $searchTerm  Search query (e.g., may contain name, phone number, or email)
     * @return ClientDto[] Array of ClientDto objects
     *
     * @throws PromuaApiException
     * @throws ConnectionException
     */
    public function getList(
        ?int $limit = null,
        ?int $lastId = null,
        ?string $searchTerm = null
    ): array {
        $params = array_filter([
            'limit' => $limit,
            'last_id' => $lastId,
            'search_term' => $searchTerm,
        ]);

        $response = $this->client->get('/clients/list', $params);

        $clients = [];
        if (isset($response['clients']) && is_array($response['clients'])) {
            foreach ($response['clients'] as $clientData) {
                $clients[] = ClientDto::fromArray($clientData);
            }
        }

        return $clients;
    }

    /**
     * Get a client by ID
     *
     * @param  int  $id  Client identifier
     * @return ClientDto The client data transfer object
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function getById(int $id): ClientDto
    {
        $response = $this->client->get("/clients/$id");

        return ClientDto::fromArray($response['client']);
    }
}
