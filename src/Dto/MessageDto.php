<?php

namespace Dvomaks\PromuaApi\Dto;

/**
 * DTO для повідомлення в системі PromUA
 *
 * Цей клас використовується для представлення даних повідомлення з API PromUA.
 * Містить інформацію про ідентифікатор повідомлення, дату створення, ім'я клієнта, телефон, текст повідомлення, тему, статус та ідентифікатор товару.
 */
class MessageDto
{
    /**
     * @param int $id Унікальний ідентифікатор повідомлення
     * @param string|null $date_created Дата створення повідомлення в форматі ISO-8601
     * @param string|null $client_full_name ПІБ клієнта
     * @param string|null $phone Телефон клієнта
     * @param string|null $message Текст повідомлення
     * @param string|null $subject Тема повідомлення
     * @param string|null $status Статус повідомлення (unread, read, deleted)
     * @param int|null $product_id Унікальний ідентифікатор товара
     */
    public function __construct(
        public int $id,
        public ?string $date_created,
        public ?string $client_full_name,
        public ?string $phone,
        public ?string $message,
        public ?string $subject,
        public ?string $status,
        public ?int $product_id,
    ) {
    }

    /**
     * Створює екземпляр MessageDto з масиву даних
     *
     * @param array $data Масив даних для створення DTO
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            date_created: $data['date_created'] ?? null,
            client_full_name: $data['client_full_name'] ?? null,
            phone: $data['phone'] ?? null,
            message: $data['message'] ?? null,
            subject: $data['subject'] ?? null,
            status: $data['status'] ?? null,
            product_id: $data['product_id'] ?? null,
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
            'date_created' => $this->date_created,
            'client_full_name' => $this->client_full_name,
            'phone' => $this->phone,
            'message' => $this->message,
            'subject' => $this->subject,
            'status' => $this->status,
            'product_id' => $this->product_id,
        ];
    }
}