<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Dto\ChatMessageDto;
use Dvomaks\PromuaApi\Dto\ChatRoomDto;
use Dvomaks\PromuaApi\Http\PromuaApiClient;

class ChatService
{
    public function __construct(private PromuaApiClient $client) {}

    /**
     * @return ChatRoomDto[]
     */
    public function getRooms(array $params = []): array
    {
        $response = $this->client->get('/chat/rooms', $params);

        $rooms = [];
        foreach ($response['data']['rooms'] as $item) {
            $rooms[] = ChatRoomDto::fromArray($item);
        }

        return $rooms;
    }

    /**
     * @return ChatMessageDto[]
     */
    public function getMessages(array $params = []): array
    {
        $response = $this->client->get('/chat/messages_history', $params);

        $messages = [];
        foreach ($response['data']['messages'] as $item) {
            $messages[] = ChatMessageDto::fromArray($item);
        }

        return $messages;
    }

    public function sendMessage(array $data): array
    {
        $response = $this->client->post('/chat/send_message', $data);

        return $response;
    }

    public function sendFile(string $filePath, array $data): array
    {
        // TODO:For file upload, we need to use a different approach
        // This would typically require the client to handle multipart form data
        $data['file'] = new \CurlFile($filePath);
        $response = $this->client->post('/chat/send_file', $data);

        return $response;
    }

    public function markMessageRead(array $data): array
    {
        $response = $this->client->post('/chat/mark_message_read', $data);

        return $response;
    }
}
