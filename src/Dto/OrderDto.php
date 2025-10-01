<?php

namespace Dvomaks\PromuaApi\Dto;

/**
 * DTO для замовлення в системі PromUA
 *
 * Цей клас використовується для представлення даних замовлення з API PromUA.
 * Містить інформацію про ідентифікатор замовлення, дату створення, клієнта, продукти, ціни, доставку, оплату та інші властивості, вказані в документації API.
 */
class OrderDto
{
    /**
     * @param  int  $id  Унікальний ідентифікатор замовлення
     * @param  string|null  $date_created  Дата створення замовлення в форматі ISO-8601
     * @param  string|null  $client_first_name  Ім'я клієнта
     * @param  string|null  $client_second_name  По-батькові клієнта
     * @param  string|null  $client_last_name  Прізвище клієнта
     * @param  int|null  $client_id  Унікальний ідентифікатор клієнта
     * @param  string|null  $client_notes  Коментар, доданий користувачем
     * @param  array|null  $products  Продукти в замовленні
     * @param  string|null  $phone  Телефон клієнта
     * @param  string|null  $email  Email клієнта
     * @param  string|null  $price  Сума замовлення без урахування вартості доставки
     * @param  string|null  $full_price  Загальна сума замовлення з урахуванням вартості доставки
     * @param  array|null  $delivery_option  Опція доставки
     * @param  array|null  $delivery_provider_data  Дані постачальника доставки
     * @param  string|null  $delivery_address  Адреса доставки
     * @param  float|null  $delivery_cost  Вартість доставки
     * @param  array|null  $payment_option  Опція оплати
     * @param  array|null  $payment_data  Дані оплати
     * @param  string|null  $status  Статус замовлення
     * @param  string|null  $status_name  Назва статуса замовлення
     * @param  string|null  $source  Джерело замовлення
     * @param  bool|null  $has_order_promo_free_delivery  Замовлення з безкоштовною доставкою
     * @param  array|null  $cpa_commission  Комісія CPA
     * @param  array|null  $utm  UTM параметри
     * @param  bool|null  $dont_call_customer_back  Клієнт просить не телефонувати
     * @param  array|null  $ps_promotion  Промоції платіжної системи
     * @param  array|null  $cancellation  Інформація про скасування замовлення
     */
    public function __construct(
        public int $id,
        public ?string $date_created,
        public ?string $client_first_name,
        public ?string $client_second_name,
        public ?string $client_last_name,
        public ?int $client_id,
        public ?string $client_notes,
        public ?array $products,
        public ?string $phone,
        public ?string $email,
        public ?string $price,
        public ?string $full_price,
        public ?array $delivery_option,
        public ?array $delivery_provider_data,
        public ?string $delivery_address,
        public ?float $delivery_cost,
        public ?array $payment_option,
        public ?array $payment_data,
        public ?string $status,
        public ?string $status_name,
        public ?string $source,
        public ?bool $has_order_promo_free_delivery,
        public ?array $cpa_commission,
        public ?array $utm,
        public ?bool $dont_call_customer_back,
        public ?array $ps_promotion,
        public ?array $cancellation,
    ) {}

    /**
     * Створює екземпляр OrderDto з масиву даних
     *
     * @param  array  $data  Масив даних для створення DTO
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            date_created: $data['date_created'] ?? null,
            client_first_name: $data['client_first_name'] ?? null,
            client_second_name: $data['client_second_name'] ?? null,
            client_last_name: $data['client_last_name'] ?? null,
            client_id: $data['client_id'] ?? null,
            client_notes: $data['client_notes'] ?? null,
            products: $data['products'] ?? null,
            phone: $data['phone'] ?? null,
            email: $data['email'] ?? null,
            price: $data['price'] ?? null,
            full_price: $data['full_price'] ?? null,
            delivery_option: $data['delivery_option'] ?? null,
            delivery_provider_data: $data['delivery_provider_data'] ?? null,
            delivery_address: $data['delivery_address'] ?? null,
            delivery_cost: $data['delivery_cost'] ?? null,
            payment_option: $data['payment_option'] ?? null,
            payment_data: $data['payment_data'] ?? null,
            status: $data['status'] ?? null,
            status_name: $data['status_name'] ?? null,
            source: $data['source'] ?? null,
            has_order_promo_free_delivery: $data['has_order_promo_free_delivery'] ?? null,
            cpa_commission: $data['cpa_commission'] ?? null,
            utm: $data['utm'] ?? null,
            dont_call_customer_back: $data['dont_call_customer_back'] ?? null,
            ps_promotion: $data['ps_promotion'] ?? null,
            cancellation: $data['cancellation'] ?? null,
        );
    }

    /**
     * Перетворює екземпляр DTO в масив
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'date_created' => $this->date_created,
            'client_first_name' => $this->client_first_name,
            'client_second_name' => $this->client_second_name,
            'client_last_name' => $this->client_last_name,
            'client_id' => $this->client_id,
            'client_notes' => $this->client_notes,
            'products' => $this->products,
            'phone' => $this->phone,
            'email' => $this->email,
            'price' => $this->price,
            'full_price' => $this->full_price,
            'delivery_option' => $this->delivery_option,
            'delivery_provider_data' => $this->delivery_provider_data,
            'delivery_address' => $this->delivery_address,
            'delivery_cost' => $this->delivery_cost,
            'payment_option' => $this->payment_option,
            'payment_data' => $this->payment_data,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'source' => $this->source,
            'has_order_promo_free_delivery' => $this->has_order_promo_free_delivery,
            'cpa_commission' => $this->cpa_commission,
            'utm' => $this->utm,
            'dont_call_customer_back' => $this->dont_call_customer_back,
            'ps_promotion' => $this->ps_promotion,
            'cancellation' => $this->cancellation,
        ];
    }
}
