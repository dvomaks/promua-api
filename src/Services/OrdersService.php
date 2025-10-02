<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Dto\OrderDto;
use Dvomaks\PromuaApi\Exceptions\PromuaApiException;
use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Illuminate\Http\Client\ConnectionException;

/**
 * OrdersService provides methods to interact with order functionality of the Promua API.
 * It allows retrieving orders list, getting a specific order by ID, updating order status,
 * attaching receipts to orders, and processing order refunds.
 */
readonly class OrdersService
{
    /**
     * OrdersService constructor.
     *
     * @param  PromuaApiClient  $client  The API client used to make requests to the Promua API
     */
    public function __construct(private PromuaApiClient $client) {}

    /**
     * Get a list of orders
     *
     * @param  string|null  $status  Filter orders by status
     * @param  string|null  $dateFrom  Request for items created after the specified date. Example - `2015-04-28T12:50:34`
     * @param  string|null  $dateTo  Request for items created before the specified date. Example - `2015-04-28T12:50:34`
     * @param  string|null  $lastModifiedFrom  Request for items modified after the specified date. Example - `2015-04-28T12:50:34`
     * @param  string|null  $lastModifiedTo  Request for items modified before the specified date. Example - `2015-04-28T12:50:34`
     * @param  int|null  $limit  Limiting the number of items in the response
     * @param  string|null  $sortDir  Sorting direction (asc/desc)
     * @param  int|null  $lastId  Limit the selection of orders with identifiers no higher than the specified one
     * @return OrderDto[] Array of OrderDto objects
     *
     * @throws PromuaApiException
     * @throws ConnectionException
     */
    public function getOrderList(
        ?string $status = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?string $lastModifiedFrom = null,
        ?string $lastModifiedTo = null,
        ?int $limit = null,
        ?string $sortDir = null,
        ?int $lastId = null
    ): array {
        $params = array_filter([
            'status' => $status,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'last_modified_from' => $lastModifiedFrom,
            'last_modified_to' => $lastModifiedTo,
            'limit' => $limit,
            'sort_dir' => $sortDir,
            'last_id' => $lastId,
        ]);

        $response = $this->client->get('/orders/list', $params);

        $orders = [];
        if (isset($response['orders']) && is_array($response['orders'])) {
            foreach ($response['orders'] as $orderData) {
                $orders[] = OrderDto::fromArray($orderData);
            }
        }

        return $orders;
    }

    /**
     * Get an order by ID
     *
     * @param  int  $id  Order identifier
     * @return OrderDto The order data transfer object
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function getById(int $id): OrderDto
    {
        $response = $this->client->get("/orders/$id");

        return OrderDto::fromArray($response);
    }

    /**
     * Update order status
     *
     * @param  int  $id  Order identifier
     * @param  string  $status  New order status
     * @return array Result of the update
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function updateStatus(int $id, string $status): array
    {
        $data = [
            'order_id' => $id,
            'status' => $status,
        ];

        return $this->client->post('/orders/status', $data);
    }

    /**
     * Attach a receipt to an order
     *
     * @param  int  $id  Order identifier
     * @param  string  $receiptId  Receipt ID
     * @return array Result of the attachment
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function attachReceipt(int $id, string $receiptId): array
    {
        $data = [
            'order_id' => $id,
            'receipt_id' => $receiptId,
        ];

        return $this->client->post('/orders/attach_receipt', $data);
    }

    /**
     * Refund an order
     *
     * @param  int  $id  Order identifier
     * @param  float  $amount  Refund amount
     * @param  string  $reason  Reason for refund
     * @return array Result of the refund
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function refund(int $id, float $amount, string $reason): array
    {
        $data = [
            'order_id' => $id,
            'amount' => $amount,
            'reason' => $reason,
        ];

        return $this->client->post('/orders/refund', $data);
    }
}
