<?php

use Dvomaks\PromuaApi\Dto\ChatMessageDto;
use Dvomaks\PromuaApi\Dto\ChatRoomDto;
use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Dvomaks\PromuaApi\Services\ChatService;
use Mockery as m;

/**
 * @property PromuaApiClient $client
 * @property ChatService $service
 */
beforeEach(function () {
    $this->client = m::mock(PromuaApiClient::class);
    $this->service = new ChatService($this->client);
});

afterEach(function () {
    m::close();
});

test('getRooms returns array of ChatRoomDto', function () {
    $mockResponse = [
        'data' => [
            'rooms' => [
                [
                    'id' => 10132,
                    'ident' => '10232_5343_buyer',
                    'date_sent' => '2023-08-22T12:50:34',
                    'status' => 'active',
                    'last_message_id' => 123123,
                    'buyer_client_id' => 532523,
                ],
                [
                    'id' => 10133,
                    'ident' => '10233_5343_buyer',
                    'date_sent' => '2023-08-23T12:50:34',
                    'status' => 'archived',
                    'last_message_id' => 123124,
                    'buyer_client_id' => 532524,
                ],
            ],
        ],
    ];

    $this->client->shouldReceive('get')
        ->with('/chat/rooms', [])
        ->once()
        ->andReturn($mockResponse);

    $result = $this->service->getRooms();

    expect($result)->toBeArray()
        ->toHaveCount(2)
        ->and($result[0])->toBeInstanceOf(ChatRoomDto::class)
        ->and($result[0]->id)->toBe(10132)
        ->and($result[0]->ident)->toBe('10232_5343_buyer')
        ->and($result[0]->status)->toBe('active')
        ->and($result[1])->toBeInstanceOf(ChatRoomDto::class)
        ->and($result[1]->id)->toBe(10133)
        ->and($result[1]->ident)->toBe('10233_5343_buyer')
        ->and($result[1]->status)->toBe('archived');
});

test('getRooms with parameters returns array of ChatRoomDto', function () {
    $params = ['status' => 'active', 'limit' => 10];
    $mockResponse = [
        'data' => [
            'rooms' => [
                [
                    'id' => 10132,
                    'ident' => '10232_5343_buyer',
                    'date_sent' => '2023-08-22T12:50:34',
                    'status' => 'active',
                    'last_message_id' => 123123,
                    'buyer_client_id' => 532523,
                ],
            ],
        ],
    ];

    $this->client->shouldReceive('get')
        ->with('/chat/rooms', $params)
        ->once()
        ->andReturn($mockResponse);

    $result = $this->service->getRooms($params);

    expect($result)->toBeArray()
        ->toHaveCount(1)
        ->and($result[0])->toBeInstanceOf(ChatRoomDto::class)
        ->and($result[0]->id)->toBe(10132)
        ->and($result[0]->status)->toBe('active');
});

test('getMessages returns array of ChatMessageDto', function () {
    $mockResponse = [
        'data' => [
            'messages' => [
                [
                    'id' => 123321,
                    'room_id' => 'room-uuid-1',
                    'room_ident' => '12332_321321_buyer',
                    'body' => 'hello',
                    'date_sent' => '2023-08-22T12:50:34',
                    'type' => 'message',
                    'status' => 'new',
                    'context_item_id' => null,
                    'context_item_image_url' => null,
                    'context_item_type' => null,
                    'user_name' => 'John Wick',
                    'user_ident' => '1233213',
                    'user_phone' => '+380665066444',
                    'buyer_client_id' => 312321,
                    'is_sender' => false,
                ],
                [
                    'id' => 123322,
                    'room_id' => 'room-uuid-2',
                    'room_ident' => '12333_321322_buyer',
                    'body' => 'world',
                    'date_sent' => '2023-08-22T12:51:34',
                    'type' => 'message',
                    'status' => 'read',
                    'context_item_id' => null,
                    'context_item_image_url' => null,
                    'context_item_type' => null,
                    'user_name' => 'Jane Doe',
                    'user_ident' => '1233214',
                    'user_phone' => '+380665066445',
                    'buyer_client_id' => 312322,
                    'is_sender' => true,
                ],
            ],
        ],
    ];

    $this->client->shouldReceive('get')
        ->with('/chat/messages_history', [])
        ->once()
        ->andReturn($mockResponse);

    $result = $this->service->getMessages();

    expect($result)->toBeArray()
        ->toHaveCount(2)
        ->and($result[0])->toBeInstanceOf(ChatMessageDto::class)
        ->and($result[0]->id)->toBe(123321)
        ->and($result[0]->body)->toBe('hello')
        ->and($result[0]->type)->toBe('message')
        ->and($result[0]->status)->toBe('new')
        ->and($result[0]->is_sender)->toBeFalse()
        ->and($result[1])->toBeInstanceOf(ChatMessageDto::class)
        ->and($result[1]->id)->toBe(123322)
        ->and($result[1]->body)->toBe('world')
        ->and($result[1]->type)->toBe('message')
        ->and($result[1]->status)->toBe('read')
        ->and($result[1]->is_sender)->toBeTrue();
});

test('sendMessage returns message ID', function () {
    $data = [
        'user_id' => '321321',
        'body' => 'hello',
        'project' => 'promua',
    ];

    $mockResponse = [
        'status' => 'ok',
        'data' => [
            'message_id' => 321312,
        ],
    ];

    $this->client->shouldReceive('post')
        ->with('/chat/send_message', $data)
        ->once()
        ->andReturn($mockResponse);

    $result = $this->service->sendMessage($data);

    expect($result)->toBeArray()
        ->and($result['status'])->toBe('ok')
        ->and($result['data']['message_id'])->toBe(321312);
});

test('markMessageRead returns success status', function () {
    $data = [
        'message_id' => 12321312,
        'room_id' => 'room-uuid-1',
    ];

    $mockResponse = [
        'status' => 'ok',
    ];

    $this->client->shouldReceive('post')
        ->with('/chat/mark_message_read', $data)
        ->once()
        ->andReturn($mockResponse);

    $result = $this->service->markMessageRead($data);

    expect($result)->toBeArray()
        ->and($result['status'])->toBe('ok');
});
