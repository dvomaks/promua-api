<?php

namespace Dvomaks\PromuaApi\Services;

use CurlFile;
use Dvomaks\PromuaApi\Dto\ChatMessageDto;
use Dvomaks\PromuaApi\Dto\ChatRoomDto;
use Dvomaks\PromuaApi\Exceptions\PromuaApiException;
use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Illuminate\Http\Client\ConnectionException;

/**
 * ChatService provides methods to interact with chat functionality of the Promua API.
 * It allows retrieving chat rooms, messages, sending messages and files, and marking messages as read.
 */
readonly class ChatService
{
    /**
     * ChatService constructor.
     *
     * @param  PromuaApiClient  $client  The API client used to make requests to the Promua API
     */
    public function __construct(private PromuaApiClient $client) {}

    /**
     * Get a list of chat rooms.
     *
     * @param  array  $params  Optional parameters to filter or modify the request
     * @return ChatRoomDto[] An array of chat room data transfer objects
     *
     * @throws PromuaApiException If there is an API error
     * @throws ConnectionException If there is a connection error
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
     * Get chat messages history.
     *
     * @param  array  $params  Optional parameters to filter or modify the request
     * @return ChatMessageDto[] An array of chat message data transfer objects
     *
     * @throws PromuaApiException If there is an API error
     * @throws ConnectionException If there is a connection error
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

    /**
     * Send a message to a chat.
     *
     * @param  array  $data  Message data including recipient, content, etc.
     * @return array Response from the API
     *
     * @throws PromuaApiException If there is an API error
     * @throws ConnectionException If there is a connection error
     */
    public function sendMessage(array $data): array
    {
        return $this->client->post('/chat/send_message', $data);
    }

    /**
     * TODO
     * Send a file to a chat.
     *
     * @param  string  $filePath  Path to the file to be sent
     * @param  array  $data  Additional data for the file sending request
     * @return array Response from the API
     *
     * @throws PromuaApiException If there is an API error
     * @throws ConnectionException If there is a connection error
     */
    public function sendFile(string $filePath, array $data): array
    {
        // TODO:For file upload, we need to use a different approach
        // This would typically require the client to handle multipart form data
        $data['file'] = new CurlFile($filePath);

        return $this->client->post('/chat/send_file', $data);
    }

    /**
     * Mark a message as read.
     *
     * @param  array  $data  Data containing message ID and other required information
     * @return array Response from the API
     *
     * @throws PromuaApiException If there is an API error
     * @throws ConnectionException If there is a connection error
     */
    public function markMessageRead(array $data): array
    {
        return $this->client->post('/chat/mark_message_read', $data);
    }
}
