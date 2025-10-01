<?php

namespace Dvomaks\PromuaApi;

use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Dvomaks\PromuaApi\Services\ChatService;
use Dvomaks\PromuaApi\Services\ClientsService;
use Dvomaks\PromuaApi\Services\DeliveryService;
use Dvomaks\PromuaApi\Services\GroupsService;
use Dvomaks\PromuaApi\Services\MessagesService;
use Dvomaks\PromuaApi\Services\OrdersService;
use Dvomaks\PromuaApi\Services\PaymentService;
use Dvomaks\PromuaApi\Services\ProductsService;

class PromuaApi
{
    public function __construct(
        protected PromuaApiClient $client
    ) {}

    public function chat(): ChatService
    {
        return new ChatService($this->client);
    }

    public function clients(): ClientsService
    {
        return new ClientsService($this->client);
    }

    public function delivery(): DeliveryService
    {
        return new DeliveryService($this->client);
    }

    public function groups(): GroupsService
    {
        return new GroupsService($this->client);
    }

    public function messages(): MessagesService
    {
        return new MessagesService($this->client);
    }

    public function orders(): OrdersService
    {
        return new OrdersService($this->client);
    }

    public function payment(): PaymentService
    {
        return new PaymentService($this->client);
    }

    public function products(): ProductsService
    {
        return new ProductsService($this->client);
    }
}
