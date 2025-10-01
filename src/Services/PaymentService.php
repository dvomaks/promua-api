<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Dto\PaymentOptionDto;
use Dvomaks\PromuaApi\Http\PromuaApiClient;

class PaymentService
{
    public function __construct(private PromuaApiClient $client) {}

    /**
     * @return PaymentOptionDto[]
     */
    public function getList(array $params = []): array
    {
        $response = $this->client->get('/payment_options/list', $params);
        
        $paymentOptions = [];
        foreach ($response['payment_options'] as $item) {
            $paymentOptions[] = PaymentOptionDto::fromArray($item);
        }

        return $paymentOptions;
    }
}