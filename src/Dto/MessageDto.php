<?php

namespace Dvomaks\PromuaApi\Dto;

/**
 * DTO для повідомлення в системі PromUA
 *
 * Цей клас використовується для представлення даних повідомлення з API PromUA.
 * Містить інформацію про ідентифікатор повідомлення, кімнату, відправника, дату створення та інші властивості, вказані в документації API.
 */
class MessageDto
{
    /**
     * @param int $id Унікальний ідентифікатор повідомлення
     * @param int|null $room_id Ідентифікатор кімнати
     * @param string|null $room_name Назва кімнати
     * @param string|null $message Текст повідомлення
     * @param string|null $date_created Дата створення повідомлення в форматі ISO-8601
     * @param string|null $date_read Дата прочитання повідомлення в форматі ISO-8601
     * @param string|null $sender_type Тип відправника
     * @param array|null $sender Відправник
     * @param array|null $product Продукт, пов'язаний з повідомленням
     * @param array|null $order Замовлення, пов'язане з повідомленням
     * @param string|null $status Статус повідомлення
     */
    public function __construct(
        public int $id,
        public ?int $room_id,
        public ?string $room_name,
        public ?string $message,
        public ?string $date_created,
        public ?string $date_read,
        public ?string $sender_type,
        public ?array $sender,
        public ?array $product,
        public ?array $order,
        public ?string $status,
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
            room_id: $data['room_id'] ?? null,
            room_name: $data['room_name'] ?? null,
            message: $data['message'] ?? null,
            date_created: $data['date_created'] ?? null,
            date_read: $data['date_read'] ?? null,
            sender_type: $data['sender_type'] ?? null,
            sender: $data['sender'] ?? null,
            product: $data['product'] ?? null,
            order: $data['order'] ?? null,
            status: $data['status'] ?? null,
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
            'room_id' => $this->room_id,
            'room_name' => $this->room_name,
            'message' => $this->message,
            'date_created' => $this->date_created,
            'date_read' => $this->date_read,
            'sender_type' => $this->sender_type,
            'sender' => $this->sender,
            'product' => $this->product,
            'order' => $this->order,
            'status' => $this->status,
        ];
    }
}