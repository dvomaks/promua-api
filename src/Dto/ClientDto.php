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
     * @param  int  $id  Унікальний ідентифікатор клієнта
     * @param  string|null  $client_full_name  ПІБ клієнта
     * @param  array|null  $phones  Список телефонів клієнта
     * @param  array|null  $emails  Список email-ів клієнта
     * @param  string|null  $comment  Примітки про клієнта
     * @param  string|null  $skype  Skype клієнта
     * @param  int|null  $orders_count  Кількість замовлень клієнта
     * @param  string|null  $total_payout  Сума всіх замовлень клієнта
     */
    public function __construct(
        public int $id,
        public ?string $client_full_name,
        public ?array $phones,
        public ?array $emails,
        public ?string $comment,
        public ?string $skype,
        public ?int $orders_count,
        public ?string $total_payout,
    ) {}

    /**
     * Створює екземпляр ClientDto з масиву даних
     *
     * @param  array  $data  Масив даних для створення DTO
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            client_full_name: $data['client_full_name'] ?? null,
            phones: $data['phones'] ?? null,
            emails: $data['emails'] ?? null,
            comment: $data['comment'] ?? null,
            skype: $data['skype'] ?? null,
            orders_count: $data['orders_count'] ?? null,
            total_payout: $data['total_payout'] ?? null,
        );
    }

    /**
     * Перетворює екземпляр DTO в масив
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'client_full_name' => $this->client_full_name,
            'phones' => $this->phones,
            'emails' => $this->emails,
            'comment' => $this->comment,
            'skype' => $this->skype,
            'orders_count' => $this->orders_count,
            'total_payout' => $this->total_payout,
        ];
    }
}
