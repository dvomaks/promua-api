<?php

use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Dvomaks\PromuaApi\Services\ClientsService;
use Dvomaks\PromuaApi\Dto\ClientDto;

beforeEach(function () {
    $this->mockClient = Mockery::mock(PromuaApiClient::class);
    $this->clientsService = new ClientsService($this->mockClient);
});

afterEach(function () {
    Mockery::close();
});

test('getList returns array of ClientDto', function () {
    $mockResponse = [
        'clients' => [
            [
                'id' => 1,
                'client_full_name' => 'John Doe',
                'phones' => ['+380123456789'],
                'emails' => ['john.doe@example.com'],
                'comment' => null,
                'skype' => null,
                'orders_count' => 0,
                'total_payout' => '0'
            ]
        ]
    ];
    
    $this->mockClient
        ->shouldReceive('get')
        ->with('/clients/list', [])
        ->andReturn($mockResponse);
    
    $result = $this->clientsService->getList();
    
    expect($result)->toBeArray();
    expect($result[0])->toBeInstanceOf(ClientDto::class);
    expect($result[0]->id)->toBe(1);
    expect($result[0]->client_full_name)->toBe('John Doe');
});

test('getList with parameters returns array of ClientDto', function () {
    $limit = 10;
    $lastId = 100;
    $searchTerm = 'John';
    
    $mockResponse = [
        'clients' => [
            [
                'id' => 2,
                'client_full_name' => 'John Smith',
                'phones' => ['+380987654321'],
                'emails' => ['john.smith@example.com'],
                'comment' => null,
                'skype' => null,
                'orders_count' => 0,
                'total_payout' => '0'
            ]
        ]
    ];
    
    $this->mockClient
        ->shouldReceive('get')
        ->with('/clients/list', [
            'limit' => $limit,
            'last_id' => $lastId,
            'search_term' => $searchTerm,
        ])
        ->andReturn($mockResponse);
    
    $result = $this->clientsService->getList($limit, $lastId, $searchTerm);
    
    expect($result)->toBeArray();
    expect($result[0])->toBeInstanceOf(ClientDto::class);
    expect($result[0]->id)->toBe(2);
    expect($result[0]->client_full_name)->toBe('John Smith');
});

test('getById returns ClientDto', function () {
    $clientId = 1;
    $mockResponse = [
        'client' => [
            'id' => $clientId,
            'client_full_name' => 'Jane Doe',
            'phones' => ['+380123456789'],
            'emails' => ['jane.doe@example.com'],
            'comment' => null,
            'skype' => null,
            'orders_count' => 0,
            'total_payout' => '0'
        ]
    ];
    
    $this->mockClient
        ->shouldReceive('get')
        ->with("/clients/{$clientId}")
        ->andReturn($mockResponse);
    
    $result = $this->clientsService->getById($clientId);
    
    expect($result)->toBeInstanceOf(ClientDto::class);
    expect($result->id)->toBe($clientId);
    expect($result->client_full_name)->toBe('Jane Doe');
});