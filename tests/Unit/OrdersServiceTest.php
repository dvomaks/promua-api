<?php

use Dvomaks\PromuaApi\Dto\OrderDto;
use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Dvomaks\PromuaApi\Services\OrdersService;

/**
 * @property PromuaApiClient $mockClient
 * @property OrdersService $service
 */
it('can get order list', function () {
    $mockClient = Mockery::mock(PromuaApiClient::class);
    $mockClient->shouldReceive('get')
        ->with('/orders/list', [
            'limit' => 10,
        ])
        ->andReturn([
            'orders' => [
                [
                    'id' => 1,
                    'date_created' => '2023-01-01T10:00:00',
                    'client_first_name' => 'John',
                    'client_last_name' => 'Doe',
                    'status' => 'new',
                    'price' => '100.00',
                ],
            ],
        ]);

    $service = new OrdersService($mockClient);
    $orders = $service->getOrderList(limit: 10);

    expect($orders)
        ->toBeArray()
        ->toHaveCount(1)
        ->and($orders[0])
        ->toBeInstanceOf(OrderDto::class)
        ->id->toBe(1)
        ->client_first_name->toBe('John')
        ->status->toBe('new');
});

it('can get order by id', function () {
    $orderId = 123;
    $orderData = [
        'id' => $orderId,
        'date_created' => '2023-01-01T10:00:00',
        'client_first_name' => 'John',
        'client_last_name' => 'Doe',
        'status' => 'new',
        'price' => '100.00',
    ];

    $mockClient = Mockery::mock(PromuaApiClient::class);
    $mockClient->shouldReceive('get')
        ->with("/orders/{$orderId}")
        ->andReturn($orderData);

    $service = new OrdersService($mockClient);
    $order = $service->getById($orderId);

    expect($order)
        ->toBeInstanceOf(OrderDto::class)
        ->id->toBe($orderId)
        ->client_first_name->toBe('John')
        ->status->toBe('new');
});

it('can update order status', function () {
    $orderId = 123;
    $newStatus = 'processed';
    $result = ['success' => true];

    $mockClient = Mockery::mock(PromuaApiClient::class);
    $mockClient->shouldReceive('post')
        ->with('/orders/status', [
            'order_id' => $orderId,
            'status' => $newStatus,
        ])
        ->andReturn($result);

    $service = new OrdersService($mockClient);
    $response = $service->updateStatus($orderId, $newStatus);

    expect($response)->toBe($result);
});

it('can attach receipt to order', function () {
    $orderId = 123;
    $receiptId = 'receipt123';
    $result = ['success' => true];

    $mockClient = Mockery::mock(PromuaApiClient::class);
    $mockClient->shouldReceive('post')
        ->with('/orders/attach_receipt', [
            'order_id' => $orderId,
            'receipt_id' => $receiptId,
        ])
        ->andReturn($result);

    $service = new OrdersService($mockClient);
    $response = $service->attachReceipt($orderId, $receiptId);

    expect($response)->toBe($result);
});

it('can refund order', function () {
    $orderId = 123;
    $amount = 50.00;
    $reason = 'Customer request';
    $result = ['success' => true];

    $mockClient = Mockery::mock(PromuaApiClient::class);
    $mockClient->shouldReceive('post')
        ->with('/orders/refund', [
            'order_id' => $orderId,
            'amount' => $amount,
            'reason' => $reason,
        ])
        ->andReturn($result);

    $service = new OrdersService($mockClient);
    $response = $service->refund($orderId, $amount, $reason);

    expect($response)->toBe($result);
});
