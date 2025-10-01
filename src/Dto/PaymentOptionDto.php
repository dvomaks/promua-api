<?php

namespace Dvomaks\PromuaApi\Dto;

/**
 * DTO для опції оплати в системі PromUA
 *
 * Цей клас використовується для представлення даних опції оплати з API PromUA.
 * Містить інформацію про ідентифікатор опції, назву, опис, тип платежу та інші властивості, вказані в документації API.
 */
class PaymentOptionDto
{
    /**
     * @param int $id Унікальний ідентифікатор опції оплати
     * @param string|null $name Назва опції оплати
     * @param string|null $description Опис опції оплати
     * @param bool|null $is_default Чи є опція оплати типовою
     * @param string|null $payment_type Тип оплати
     * @param array|null $payment_data Дані оплати
     * @param string|null $date_created Дата створення опції оплати в форматі ISO-8601
     * @param string|null $date_updated Дата оновлення опції оплати в форматі ISO-8601
     */
    public function __construct(
        public int $id,
        public ?string $name,
        public ?string $description,
        public ?bool $is_default,
        public ?string $payment_type,
        public ?array $payment_data,
        public ?string $date_created,
        public ?string $date_updated,
    ) {
    }

    /**
     * Створює екземпляр PaymentOptionDto з масиву даних
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
            payment_type: $data['payment_type'] ?? null,
            payment_data: $data['payment_data'] ?? null,
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
            'payment_type' => $this->payment_type,
            'payment_data' => $this->payment_data,
            'date_created' => $this->date_created,
            'date_updated' => $this->date_updated,
        ];
    }
}