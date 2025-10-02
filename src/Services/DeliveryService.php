<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Dto\DeliveryOptionDto;
use Dvomaks\PromuaApi\Exceptions\PromuaApiException;
use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Illuminate\Http\Client\ConnectionException;

/**
 * DeliveryService provides methods to interact with delivery options functionality of the Promua API.
 * It allows retrieving a list of available delivery options.
 */
readonly class DeliveryService
{
    /**
     * DeliveryService constructor.
     *
     * @param  PromuaApiClient  $client  The API client used to make requests to the Promua API
     */
    public function __construct(private PromuaApiClient $client) {}

    /**
     * Get a list of delivery options
     *
     * @param  array  $params  Optional parameters to filter or modify the request
     * @return DeliveryOptionDto[] Array of delivery option data transfer objects
     *
     * @throws PromuaApiException
     * @throws ConnectionException
     */
    public function getList(array $params = []): array
    {
        $response = $this->client->get('/delivery_options/list', $params);

        $deliveryOptions = [];
        foreach ($response['delivery_options'] as $item) {
            $deliveryOptions[] = DeliveryOptionDto::fromArray($item);
        }

        return $deliveryOptions;
    }
}
