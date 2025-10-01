<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Dto\DeliveryOptionDto;
use Dvomaks\PromuaApi\Http\PromuaApiClient;

class DeliveryService
{
    public function __construct(private PromuaApiClient $client) {}

    /**
     * @return DeliveryOptionDto[]
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
