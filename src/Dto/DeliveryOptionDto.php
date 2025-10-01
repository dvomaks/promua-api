<?php

namespace Dvomaks\PromuaApi\Dto;

/**
 * DTO для опції доставки в системі PromUA
 *
 * Цей клас використовується для представлення даних опції доставки з API PromUA.
 * Містить інформацію про ідентифікатор опції, назву, опис, тип доставки, вартість та інші властивості, вказані в документації API.
 */
class DeliveryOptionDto
{
    /**
     * @param int $id Унікальний ідентифікатор опції доставки
     * @param string|null $name Назва опції доставки
     * @param string|null $description Опис опції доставки
     * @param bool|null $is_default Чи є опція доставки типовою
     * @param string|null $delivery_type Тип доставки
     * @param float|null $min_order_amount Мінімальна сума замовлення
     * @param float|null $cost Вартість доставки
     * @param array|null $delivery_data Дані доставки
     * @param string|null $date_created Дата створення опції доставки в форматі ISO-8601
     * @param string|null $date_updated Дата оновлення опції доставки в форматі ISO-8601
     */
    public function __construct(
        public int $id,
        public ?string $name,
        public ?string $description,
        public ?bool $is_default,
        public ?string $delivery_type,
        public ?float $min_order_amount,
        public ?float $cost,
        public ?array $delivery_data,
        public ?string $date_created,
        public ?string $date_updated,
    ) {
    }

    /**
     * Створює екземпляр DeliveryOptionDto з масиву даних
     *
     * @param array $data Масив даних для створення DTO
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            name: $data['name'] ?? null,
            description: $data['description'] ?? null,
            is_default: $data['is_default'] ?? null,
            delivery_type: $data['delivery_type'] ?? null,
            min_order_amount: $data['min_order_amount'] ?? null,
            cost: $data['cost'] ?? null,
            delivery_data: $data['delivery_data'] ?? null,
            date_created: $data['date_created'] ?? null,
            date_updated: $data['date_updated'] ?? null,
        );
    }

    /**
     * Перетворює екземпляр DTO в масив
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_default' => $this->is_default,
            'delivery_type' => $this->delivery_type,
            'min_order_amount' => $this->min_order_amount,
            'cost' => $this->cost,
            'delivery_data' => $this->delivery_data,
            'date_created' => $this->date_created,
            'date_updated' => $this->date_updated,
        ];
    }
}