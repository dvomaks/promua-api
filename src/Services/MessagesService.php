<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Dto\MessageDto;
use Dvomaks\PromuaApi\Exceptions\PromuaApiException;
use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Illuminate\Http\Client\ConnectionException;

/**
 * MessagesService provides methods to interact with message functionality of the Promua API.
 * It allows retrieving messages list, getting a specific message by ID, replying to messages, and setting message statuses.
 */
readonly class MessagesService
{
    /**
     * MessagesService constructor.
     *
     * @param  PromuaApiClient  $client  The API client used to make requests to the Promua API
     */
    public function __construct(private PromuaApiClient $client) {}

    /**
     * Get a list of messages
     *
     * @param  string|null  $status  Message status (unread, read, deleted)
     * @param  string|null  $dateFrom  Start date in ISO-8601 format
     * @param  string|null  $dateTo  End date in ISO-8601 format
     * @param  int|null  $limit  Limit the number of messages
     * @param  int|null  $lastId  Limit the selection of messages with identifiers not higher than the specified one
     * @return MessageDto[] Array of message data transfer objects
     *
     * @throws PromuaApiException
     * @throws ConnectionException
     */
    public function getList(
        ?string $status = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?int $limit = null,
        ?int $lastId = null
    ): array {
        $params = array_filter([
            'status' => $status,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'limit' => $limit,
            'last_id' => $lastId,
        ]);

        $response = $this->client->get('/messages/list', $params);

        $messages = [];
        foreach ($response['messages'] ?? [] as $messageData) {
            $messages[] = MessageDto::fromArray($messageData);
        }

        return $messages;
    }

    /**
     * Get a message by ID
     *
     * @param  int  $id  Message identifier
     * @return MessageDto The message data transfer object
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function getById(int $id): MessageDto
    {
        $response = $this->client->get("/messages/$id");

        return MessageDto::fromArray($response['message']);
    }

    /**
     * Reply to a message
     *
     * @param  int  $id  Message identifier
     * @param  string  $message  Reply text
     * @return array Array with the identifier of the processed message
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function reply(int $id, string $message): array
    {
        $params = [
            'id' => $id,
            'message' => $message,
        ];

        return $this->client->post('/messages/reply', $params);
    }

    /**
     * Change message statuses
     *
     * @param  string  $status  Message status (unread, read, deleted)
     * @param  array  $ids  Array of message identifiers
     * @return array Array with identifiers of processed messages
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function setStatus(string $status, array $ids): array
    {
        $params = [
            'status' => $status,
            'ids' => $ids,
        ];

        return $this->client->post('/messages/set_status', $params);
    }
}
