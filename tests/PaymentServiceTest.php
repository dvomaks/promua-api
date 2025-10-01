<?php

use Dvomaks\PromuaApi\Dto\PaymentOptionDto;
use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Dvomaks\PromuaApi\Services\PaymentService;
use Mockery as m;

beforeEach(function () {
    $this->client = m::mock(PromuaApiClient::class);
    $this->service = new PaymentService($this->client);
});

afterEach(function () {
    m::close();
});

test('getList returns array of PaymentOptionDto', function () {
    $mockResponse = [
        'payment_options' => [
            [
                'id' => 1,
                'name' => 'Credit Card',
                'description' => 'Payment by credit card',
            ],
            [
                'id' => 2,
                'name' => 'Bank Transfer',
                'description' => 'Payment by bank transfer',
            ],
        ],
    ];

    $this->client->shouldReceive('get')
        ->with('/payment_options/list', [])
        ->once()
        ->andReturn($mockResponse);

    $result = $this->service->getList();

    expect($result)->toBeArray()
        ->toHaveCount(2);

    expect($result[0])
        ->toBeInstanceOf(PaymentOptionDto::class)
        ->and($result[0]->id)->toBe(1)
        ->and($result[0]->name)->toBe('Credit Card')
        ->and($result[0]->description)->toBe('Payment by credit card');

    expect($result[1])
        ->toBeInstanceOf(PaymentOptionDto::class)
        ->and($result[1]->id)->toBe(2)
        ->and($result[1]->name)->toBe('Bank Transfer')
        ->and($result[1]->description)->toBe('Payment by bank transfer');
});

test('getList with parameters returns array of PaymentOptionDto', function () {
    $params = ['X-LANGUAGE' => 'uk'];
    $mockResponse = [
        'payment_options' => [
            [
                'id' => 1,
                'name' => 'Кредитна картка',
                'description' => 'Оплата кредитною карткою',
            ],
        ],
    ];

    $this->client->shouldReceive('get')
        ->with('/payment_options/list', $params)
        ->once()
        ->andReturn($mockResponse);

    $result = $this->service->getList($params);

    expect($result)->toBeArray()
        ->toHaveCount(1)
        ->and($result[0])->toBeInstanceOf(PaymentOptionDto::class)
        ->and($result[0]->id)->toBe(1)
        ->and($result[0]->name)->toBe('Кредитна картка')
        ->and($result[0]->description)->toBe('Оплата кредитною карткою');
});