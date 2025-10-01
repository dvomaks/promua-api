<?php

namespace Dvomaks\PromuaApi\Dto;

/**
 * DTO для чат-кімнати в системі PromUA
 *
 * Цей клас використовується для представлення даних чат-кімнати з API PromUA.
 * Містить інформацію про ідентифікатор кімнати, дату останнього повідомлення та інші властивості, вказані в документації API.
 */
class ChatRoomDto
{
    /**
     * @param  int  $id  Унікальний ідентифікатор чат-кімнати
     * @param  string|null  $ident  Ідентифікатор кімнати чату в форматі {user_id}_{company_id}_buyer
     * @param  string|null  $date_sent  Дата відправки останнього повідомлення в кімнаті. Часовий пояс UTC+0
     * @param  string|null  $status  Статус кімнати (active, archived, banned)
     * @param  int|null  $last_message_id  ID останнього повідомлення в кімнаті
     * @param  int|null  $buyer_client_id  Ідентифікатор клієнта компанії з яким створено чат
     */
    public function __construct(
        public int $id,
        public ?string $ident,
        public ?string $date_sent,
        public ?string $status,
        public ?int $last_message_id,
        public ?int $buyer_client_id,
    ) {}

    /**
     * Створює екземпляр ChatRoomDto з масиву даних
     *
     * @param  array  $data  Масив даних для створення DTO
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            ident: $data['ident'] ?? null,
            date_sent: $data['date_sent'] ?? null,
            status: $data['status'] ?? null,
            last_message_id: $data['last_message_id'] ?? null,
            buyer_client_id: $data['buyer_client_id'] ?? null,
        );
    }

    /**
     * Перетворює екземпляр DTO в масив
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'ident' => $this->ident,
            'date_sent' => $this->date_sent,
            'status' => $this->status,
            'last_message_id' => $this->last_message_id,
            'buyer_client_id' => $this->buyer_client_id,
        ];
    }
}
