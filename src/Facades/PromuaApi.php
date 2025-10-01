<?php

namespace Dvomaks\PromuaApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dvomaks\PromuaApi\PromuaApi
 *
 * @method static \Dvomaks\PromuaApi\Services\ChatService chat()
 * @method static \Dvomaks\PromuaApi\Services\ClientsService clients()
 * @method static \Dvomaks\PromuaApi\Services\DeliveryService delivery()
 * @method static \Dvomaks\PromuaApi\Services\GroupsService groups()
 * @method static \Dvomaks\PromuaApi\Services\MessagesService messages()
 * @method static \Dvomaks\PromuaApi\Services\OrdersService orders()
 * @method static \Dvomaks\PromuaApi\Services\PaymentService payment()
 * @method static \Dvomaks\PromuaApi\Services\ProductsService products()
 */
class PromuaApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Dvomaks\PromuaApi\PromuaApi::class;
    }
}
