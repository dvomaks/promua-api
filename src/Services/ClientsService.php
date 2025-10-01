<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Dto\ClientDto;
use Dvomaks\PromuaApi\Http\PromuaApiClient;

class ClientsService
{
    public function __construct(
        protected PromuaApiClient $client
    ) {}

    /**
     * Отримує список клієнтів
     *
     * @param  int|null  $limit  Обмеження кількості клієнтів у відповіді
     * @param  int|null  $lastId  Обмежити вибірку клієнтів з ідентифікаторами не вище вказаного
     * @param  string|null  $searchTerm  Пошуковий запит (наприклад, може містити ім'я, номер телефону чи email)
     * @return array Масив ClientDto
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
     * Отримує клієнта за ідентифікатором
     *
     * @param  int  $id  Ідентифікатор клієнта
     */
    public function getById(int $id): ClientDto
    {
        $response = $this->client->get("/clients/{$id}");

        return ClientDto::fromArray($response['client']);
    }
}
