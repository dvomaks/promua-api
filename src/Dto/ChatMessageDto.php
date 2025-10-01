<?php

namespace Dvomaks\PromuaApi\Dto;

/**
 * DTO для повідомлення в чаті в системі PromUA
 *
 * Цей клас використовується для представлення даних повідомлення з API PromUA.
 * Містить інформацію про ідентифікатор повідомлення, кімнату, вміст, тип, статус та інші властивості, вказані в документації API.
 */
class ChatMessageDto
{
    /**
     * @param int $id Унікальний ідентифікатор повідомлення
     * @param string $room_id Унікальний ідентифікатор кімнати чату
     * @param string $room_ident Ідент кімнати чату в форматі {user_id}_{company_id}_buyer
     * @param string|null $body Вміст повідомлення
     * @param string $date_sent Дата відправки повідомлення (UTC+0)
     * @param string $type Тип повідомлення (message, context, notification, system)
     * @param string $status Статус повідомлення (new, read)
     * @param int|null $context_item_id Ідентифікатор сутності контексту (замовлення або товару)
     * @param string|null $context_item_image_url Посилання на зображення контексту файлу
     * @param string|null $context_item_type Тип контексту повідомлення (null, product, order, file)
     * @param string $user_name Ім'я користувача відправника повідомлення
     * @param string $user_ident Ідентифікатор користувача відправника повідомлення
     * @param string|null $user_phone Номер телефону користувача відправника повідомлення
     * @param int|null $buyer_client_id Ідентифікатор клієнта компанії з яким створено чат
     * @param bool $is_sender true якщо відправником повідомлення є компанія або менеджер компанії
     */
    public int $id;
    public string $room_id;
    public string $room_ident;
    public ?string $body;
    public string $date_sent;
    public string $type;
    public string $status;
    public ?int $context_item_id;
    public ?string $context_item_image_url;
    public ?string $context_item_type;
    public string $user_name;
    public string $user_ident;
    public ?string $user_phone;
    public ?int $buyer_client_id;
    public bool $is_sender;

    public function __construct(
        int $id,
        string $room_id,
        string $room_ident,
        ?string $body,
        string $date_sent,
        string $type,
        string $status,
        ?int $context_item_id,
        ?string $context_item_image_url,
        ?string $context_item_type,
        string $user_name,
        string $user_ident,
        ?string $user_phone,
        ?int $buyer_client_id,
        bool $is_sender
    ) {
        $this->id = $id;
        $this->room_id = $room_id;
        $this->room_ident = $room_ident;
        $this->body = $body;
        $this->date_sent = $date_sent;
        $this->type = $type;
        $this->status = $status;
        $this->context_item_id = $context_item_id;
        $this->context_item_image_url = $context_item_image_url;
        $this->context_item_type = $context_item_type;
        $this->user_name = $user_name;
        $this->user_ident = $user_ident;
        $this->user_phone = $user_phone;
        $this->buyer_client_id = $buyer_client_id;
        $this->is_sender = $is_sender;
    }

    /**
     * Створює екземпляр ChatMessageDto з масиву даних
     *
     * @param array $data Масив даних для створення DTO
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['room_id'],
            $data['room_ident'],
            $data['body'] ?? null,
            $data['date_sent'],
            $data['type'],
            $data['status'],
            $data['context_item_id'] ?? null,
            $data['context_item_image_url'] ?? null,
            $data['context_item_type'] ?? null,
            $data['user_name'],
            $data['user_ident'],
            $data['user_phone'] ?? null,
            $data['buyer_client_id'] ?? null,
            $data['is_sender']
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
            'room_ident' => $this->room_ident,
            'body' => $this->body,
            'date_sent' => $this->date_sent,
            'type' => $this->type,
            'status' => $this->status,
            'context_item_id' => $this->context_item_id,
            'context_item_image_url' => $this->context_item_image_url,
            'context_item_type' => $this->context_item_type,
            'user_name' => $this->user_name,
            'user_ident' => $this->user_ident,
            'user_phone' => $this->user_phone,
            'buyer_client_id' => $this->buyer_client_id,
            'is_sender' => $this->is_sender,
        ];
    }
}