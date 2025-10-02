<?php

use Dvomaks\PromuaApi\Dto\DeliveryOptionDto;
use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Dvomaks\PromuaApi\Services\DeliveryService;
use Mockery as m;

beforeEach(function () {
    $this->client = m::mock(PromuaApiClient::class);
    $this->service = new DeliveryService($this->client);
});

afterEach(function () {
    m::close();
});

test('getList returns array of DeliveryOptionDto', function () {
    $mockResponse = [
        'delivery_options' => [
            [
                'id' => 1,
                'name' => 'Courier',
                'comment' => 'Courier delivery service',
                'enabled' => true,
                'type' => 'courier',
            ],
            [
                'id' => 2,
                'name' => 'Self-Pickup',
                'comment' => 'Self-pickup from our store',
                'enabled' => true,
                'type' => 'pickup',
            ],
        ],
    ];

    $this->client->shouldReceive('get')
        ->with('/delivery_options/list', [])
        ->once()
        ->andReturn($mockResponse);

    $result = $this->service->getList();

    expect($result)->toBeArray()
        ->toHaveCount(2);

    expect($result[0])
        ->toBeInstanceOf(DeliveryOptionDto::class)
        ->and($result[0]->id)->toBe(1)
        ->and($result[0]->name)->toBe('Courier')
        ->and($result[0]->comment)->toBe('Courier delivery service')
        ->and($result[0]->enabled)->toBeTrue()
        ->and($result[0]->type)->toBe('courier');

    expect($result[1])
        ->toBeInstanceOf(DeliveryOptionDto::class)
        ->and($result[1]->id)->toBe(2)
        ->and($result[1]->name)->toBe('Self-Pickup')
        ->and($result[1]->comment)->toBe('Self-pickup from our store')
        ->and($result[1]->enabled)->toBeTrue()
        ->and($result[1]->type)->toBe('pickup');
});

test('getList with parameters returns array of DeliveryOptionDto', function () {
    $params = ['X-LANGUAGE' => 'uk'];
    $mockResponse = [
        'delivery_options' => [
            [
                'id' => 1,
                'name' => 'Кур\'єр',
                'comment' => 'Кур\'єрська доставка',
                'enabled' => true,
                'type' => 'courier',
            ],
        ],
    ];

    $this->client->shouldReceive('get')
        ->with('/delivery_options/list', $params)
        ->once()
        ->andReturn($mockResponse);

    $result = $this->service->getList($params);

    expect($result)->toBeArray()
        ->toHaveCount(1)
        ->and($result[0])->toBeInstanceOf(DeliveryOptionDto::class)
        ->and($result[0]->id)->toBe(1)
        ->and($result[0]->name)->toBe('Кур\'єр')
        ->and($result[0]->comment)->toBe('Кур\'єрська доставка')
        ->and($result[0]->enabled)->toBeTrue()
        ->and($result[0]->type)->toBe('courier');
});
