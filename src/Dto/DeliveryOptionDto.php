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
     * @param  int  $id  Унікальний ідентифікатор опції доставки
     * @param  string  $name  Назва опції доставки
     * @param  string  $comment  Опис опції доставки
     * @param  bool  $enabled  Чи є опція доставки активна
     * @param  string  $type  Тип доставки
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $comment,
        public bool $enabled,
        public string $type,
    ) {}

    /**
     * Створює екземпляр DeliveryOptionDto з масиву даних
     *
     * @param  array  $data  Масив даних для створення DTO
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            comment: $data['comment'],
            enabled: $data['enabled'],
            type: $data['type'],
        );
    }

    /**
     * Перетворює екземпляр DTO в масив
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'comment' => $this->comment,
            'enabled' => $this->enabled,
            'type' => $this->type,
        ];
    }
}
