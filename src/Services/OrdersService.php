<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Dto\OrderDto;
use Dvomaks\PromuaApi\Http\PromuaApiClient;

class OrdersService
{
    public function __construct(
        protected PromuaApiClient $client
    ) {}

    /**
     * Отримує список замовлень
     *
     * @param  string|null  $lastModifiedFrom  Request for items modified after the specified date. Example - `2015-04-28T12:50:34`.
     * @param  string|null  $lastModifiedTo  Request for items modified before the specified date. Example - `2015-04-28T12:50:34`.
     * @param  int|null  $limit  Limiting the number of items in the response.
     * @param  int|null  $lastId  Limit the selection of orders with identifiers no higher than the specified one.
     * @param  string|null  $status  Filter orders by status.
     * @return array Масив OrderDto
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
     * Отримує замовлення за ідентифікатором
     *
     * @param  int  $id  Ідентифікатор замовлення
     */
    public function getById(int $id): OrderDto
    {
        $response = $this->client->get("/orders/{$id}");

        return OrderDto::fromArray($response);
    }

    /**
     * Оновлює статус замовлення
     *
     * @param  int  $id  Ідентифікатор замовлення
     * @param  string  $status  Новий статус замовлення
     * @return array Результат оновлення
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
     * Прикріплює квитанцію до замовлення
     *
     * @param  int  $id  Ідентифікатор замовлення
     * @param  string  $receiptId  ID квитанції
     * @return array Результат прикріплення
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
     * Повертає замовлення
     *
     * @param  int  $id  Ідентифікатор замовлення
     * @param  float  $amount  Сума повернення
     * @param  string  $reason  Причина повернення
     * @return array Результат повернення
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
