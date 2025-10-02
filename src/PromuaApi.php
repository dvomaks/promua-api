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

/**
 * Main Promua API class that provides access to various service classes.
 * Acts as a facade to access different API services like chat, clients, delivery, groups, etc.
 */
class PromuaApi
{
    /**
     * PromuaApi constructor.
     *
     * @param  PromuaApiClient  $client  The API client used to make requests to the Promua API
     */
    public function __construct(
        protected PromuaApiClient $client
    ) {}

    /**
     * Get the chat service instance
     *
     * @return ChatService The chat service
     */
    public function chat(): ChatService
    {
        return new ChatService($this->client);
    }

    /**
     * Get the clients service instance
     *
     * @return ClientsService The clients service
     */
    public function clients(): ClientsService
    {
        return new ClientsService($this->client);
    }

    /**
     * Get the delivery service instance
     *
     * @return DeliveryService The delivery service
     */
    public function delivery(): DeliveryService
    {
        return new DeliveryService($this->client);
    }

    /**
     * Get the groups service instance
     *
     * @return GroupsService The groups service
     */
    public function groups(): GroupsService
    {
        return new GroupsService($this->client);
    }

    /**
     * Get the messages service instance
     *
     * @return MessagesService The messages service
     */
    public function messages(): MessagesService
    {
        return new MessagesService($this->client);
    }

    /**
     * Get the orders service instance
     *
     * @return OrdersService The orders service
     */
    public function orders(): OrdersService
    {
        return new OrdersService($this->client);
    }

    /**
     * Get the payment service instance
     *
     * @return PaymentService The payment service
     */
    public function payment(): PaymentService
    {
        return new PaymentService($this->client);
    }

    /**
     * Get the products service instance
     *
     * @return ProductsService The products service
     */
    public function products(): ProductsService
    {
        return new ProductsService($this->client);
    }
}
