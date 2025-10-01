<?php

use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Dvomaks\PromuaApi\Services\MessagesService;
use Dvomaks\PromuaApi\Dto\MessageDto;

beforeEach(function () {
    $this->mockClient = Mockery::mock(PromuaApiClient::class);
    $this->messagesService = new MessagesService($this->mockClient);
});

afterEach(function () {
    Mockery::close();
});

test('getList returns array of MessageDto', function () {
    $mockResponse = [
        'messages' => [
            [
                'id' => 1,
                'date_created' => '2023-01-01T10:00:00+00:00',
                'client_full_name' => 'John Doe',
                'phone' => '+380123456789',
                'message' => 'Hello, I have a question',
                'subject' => 'Question',
                'status' => 'unread',
                'product_id' => 123
            ]
        ]
    ];
    
    $this->mockClient
        ->shouldReceive('get')
        ->with('/messages/list', [])
        ->andReturn($mockResponse);
    
    $result = $this->messagesService->getList();
    
    expect($result)->toBeArray();
    expect($result[0])->toBeInstanceOf(MessageDto::class);
    expect($result[0]->id)->toBe(1);
    expect($result[0]->client_full_name)->toBe('John Doe');
});

test('getList with parameters returns array of MessageDto', function () {
    $status = 'unread';
    $dateFrom = '2023-01-01T00:00:00';
    $dateTo = '2023-12-31T23:59:59';
    $limit = 10;
    $lastId = 100;
    
    $mockResponse = [
        'messages' => [
            [
                'id' => 2,
                'date_created' => '2023-06-15T15:30:00+00:00',
                'client_full_name' => 'Jane Smith',
                'phone' => '+380987654321',
                'message' => 'Another message',
                'subject' => 'Info',
                'status' => 'read',
                'product_id' => 456
            ]
        ]
    ];
    
    $this->mockClient
        ->shouldReceive('get')
        ->with('/messages/list', [
            'status' => $status,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'limit' => $limit,
            'last_id' => $lastId,
        ])
        ->andReturn($mockResponse);
    
    $result = $this->messagesService->getList($status, $dateFrom, $dateTo, $limit, $lastId);
    
    expect($result)->toBeArray();
    expect($result[0])->toBeInstanceOf(MessageDto::class);
    expect($result[0]->id)->toBe(2);
    expect($result[0]->client_full_name)->toBe('Jane Smith');
    expect($result[0]->status)->toBe('read');
});

test('getById returns MessageDto', function () {
    $messageId = 1;
    $mockResponse = [
        'message' => [
            'id' => $messageId,
            'date_created' => '2023-01-01T10:00:00+00:00',
            'client_full_name' => 'John Doe',
            'phone' => '+380123456789',
            'message' => 'Hello, I have a question',
            'subject' => 'Question',
            'status' => 'unread',
            'product_id' => 123
        ]
    ];
    
    $this->mockClient
        ->shouldReceive('get')
        ->with("/messages/{$messageId}")
        ->andReturn($mockResponse);
    
    $result = $this->messagesService->getById($messageId);
    
    expect($result)->toBeInstanceOf(MessageDto::class);
    expect($result->id)->toBe($messageId);
    expect($result->client_full_name)->toBe('John Doe');
    expect($result->status)->toBe('unread');
});

test('reply returns processed ids', function () {
    $messageId = 1;
    $replyMessage = 'Thank you for your message';
    $mockResponse = [
        'processed_ids' => [$messageId]
    ];
    
    $this->mockClient
        ->shouldReceive('post')
        ->with('/messages/reply', [
            'id' => $messageId,
            'message' => $replyMessage
        ])
        ->andReturn($mockResponse);
    
    $result = $this->messagesService->reply($messageId, $replyMessage);
    
    expect($result)->toBeArray();
    expect($result['processed_ids'])->toBeArray();
    expect($result['processed_ids'][0])->toBe($messageId);
});

test('setStatus returns processed ids', function () {
    $status = 'read';
    $ids = [1, 2, 3];
    $mockResponse = [
        'processed_ids' => $ids
    ];
    
    $this->mockClient
        ->shouldReceive('post')
        ->with('/messages/set_status', [
            'status' => $status,
            'ids' => $ids
        ])
        ->andReturn($mockResponse);
    
    $result = $this->messagesService->setStatus($status, $ids);
    
    expect($result)->toBeArray();
    expect($result['processed_ids'])->toBeArray();
    expect($result['processed_ids'])->toBe($ids);
});