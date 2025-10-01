<?php

namespace Dvomaks\PromuaApi\Dto;

/**
 * DTO для клієнта в системі PromUA
 *
 * Цей клас використовується для представлення даних клієнта з API PromUA.
 * Містить інформацію про ідентифікатор клієнта, ім'я, прізвище, email, телефон, компанію та інші властивості, вказані в документації API.
 */
class ClientDto
{
    /**
     * @param int $id Унікальний ідентифікатор клієнта
     * @param string|null $first_name Ім'я клієнта
     * @param string|null $second_name По-батькові клієнта
     * @param string|null $last_name Прізвище клієнта
     * @param string|null $email Email клієнта
     * @param string|null $phone Телефон клієнта
     * @param string|null $company_name Назва компанії
     * @param string|null $company_edrpou Код ЄДРПОУ компанії
     * @param string|null $company_address Адреса компанії
     * @param array|null $orders Замовлення клієнта
     * @param string|null $date_created Дата створення клієнта в форматі ISO-8601
     * @param string|null $date_updated Дата оновлення клієнта в форматі ISO-8601
     */
    public function __construct(
        public int $id,
        public ?string $first_name,
        public ?string $second_name,
        public ?string $last_name,
        public ?string $email,
        public ?string $phone,
        public ?string $company_name,
        public ?string $company_edrpou,
        public ?string $company_address,
        public ?array $orders,
        public ?string $date_created,
        public ?string $date_updated,
    ) {
    }

    /**
     * Створює екземпляр ClientDto з масиву даних
     *
     * @param array $data Масив даних для створення DTO
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            first_name: $data['first_name'] ?? null,
            second_name: $data['second_name'] ?? null,
            last_name: $data['last_name'] ?? null,
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            company_name: $data['company_name'] ?? null,
            company_edrpou: $data['company_edrpou'] ?? null,
            company_address: $data['company_address'] ?? null,
            orders: $data['orders'] ?? null,
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
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'company_edrpou' => $this->company_edrpou,
            'company_address' => $this->company_address,
            'orders' => $this->orders,
            'date_created' => $this->date_created,
            'date_updated' => $this->date_updated,
        ];
    }
}