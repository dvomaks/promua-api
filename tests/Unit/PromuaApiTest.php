<?php

use Dvomaks\PromuaApi\Facades\PromuaApi;
use Dvomaks\PromuaApi\Services\ChatService;
use Dvomaks\PromuaApi\Services\ClientsService;
use Dvomaks\PromuaApi\Services\DeliveryService;
use Dvomaks\PromuaApi\Services\GroupsService;
use Dvomaks\PromuaApi\Services\MessagesService;
use Dvomaks\PromuaApi\Services\OrdersService;
use Dvomaks\PromuaApi\Services\PaymentService;
use Dvomaks\PromuaApi\Services\ProductsService;

test('chat method returns chat service', function () {
    expect(PromuaApi::chat())->toBeInstanceOf(ChatService::class);
});

test('clients method returns clients service', function () {
    expect(PromuaApi::clients())->toBeInstanceOf(ClientsService::class);
});

test('delivery method returns delivery service', function () {
    expect(PromuaApi::delivery())->toBeInstanceOf(DeliveryService::class);
});

test('groups method returns groups service', function () {
    expect(PromuaApi::groups())->toBeInstanceOf(GroupsService::class);
});

test('messages method returns messages service', function () {
    expect(PromuaApi::messages())->toBeInstanceOf(MessagesService::class);
});

test('orders method returns orders service', function () {
    expect(PromuaApi::orders())->toBeInstanceOf(OrdersService::class);
});

test('payment method returns payment service', function () {
    expect(PromuaApi::payment())->toBeInstanceOf(PaymentService::class);
});

test('products method returns products service', function () {
    expect(PromuaApi::products())->toBeInstanceOf(ProductsService::class);
});
