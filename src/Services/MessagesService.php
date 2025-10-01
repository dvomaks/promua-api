<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Dvomaks\PromuaApi\Dto\MessageDto;

class MessagesService
{
    public function __construct(
        private PromuaApiClient $client
    ) {
    }

    /**
     * Отримує список повідомлень
     *
     * @param string|null $status Статус повідомлення (unread, read, deleted)
     * @param string|null $dateFrom Дата початку у форматі ISO-8601
     * @param string|null $dateTo Дата завершення у форматі ISO-8601
     * @param int|null $limit Обмеження кількості повідомлень
     * @param int|null $lastId Обмежити вибірку повідомлень з ідентифікаторами не вище вказаного
     * @return MessageDto[]
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
     * Отримує повідомлення за ідентифікатором
     *
     * @param int $id Ідентифікатор повідомлення
     * @return MessageDto
     */
    public function getById(int $id): MessageDto
    {
        $response = $this->client->get("/messages/{$id}");
        
        return MessageDto::fromArray($response['message']);
    }

    /**
     * Відповідає на повідомлення
     *
     * @param int $id Ідентифікатор повідомлення
     * @param string $message Текст відповіді
     * @return array Масив з ідентифікатором обробленого повідомлення
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
     * Змінює статус повідомлень
     *
     * @param string $status Статус повідомлення (unread, read, deleted)
     * @param array $ids Масив ідентифікаторів повідомлень
     * @return array Масив з ідентифікаторами оброблених повідомлень
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