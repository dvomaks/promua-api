<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Dto\PaymentOptionDto;
use Dvomaks\PromuaApi\Exceptions\PromuaApiException;
use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Illuminate\Http\Client\ConnectionException;

/**
 * PaymentService provides methods to interact with payment options functionality of the Promua API.
 * It allows retrieving a list of available payment options.
 */
readonly class PaymentService
{
    /**
     * PaymentService constructor.
     *
     * @param  PromuaApiClient  $client  The API client used to make requests to the Promua API
     */
    public function __construct(private PromuaApiClient $client) {}

    /**
     * Get a list of payment options
     *
     * @param  array  $params  Optional parameters to filter or modify the request
     * @return PaymentOptionDto[] Array of payment option data transfer objects
     *
     * @throws PromuaApiException
     * @throws ConnectionException
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
