<?php

namespace Dvomaks\PromuaApi\Dto;

/**
 * DTO для групи в системі PromUA
 *
 * Цей клас використовується для представлення даних групи з API PromUA.
 * Містить інформацію про ідентифікатор групи, назву, опис, зображення, ієрархію та інші властивості, вказані в документації API.
 */
class GroupDto
{
    /**
     * @param int $id Унікальний ідентифікатор групи
     * @param string|null $name Назва групи
     * @param array|null $name_multilang Багатомовна назва групи
     * @param string|null $description Опис групи
     * @param array|null $description_multilang Багатомовний опис групи
     * @param string|null $url URL групи
     * @param string|null $image Зображення групи
     * @param int|null $parent_id Ідентифікатор батьківської групи
     * @param int|null $level Рівень групи
     * @param int|null $position Позиція групи
     * @param bool|null $has_children Чи має група дочірні елементи
     * @param array|null $children Дочірні елементи групи
     * @param string|null $date_created Дата створення групи в форматі ISO-8601
     * @param string|null $date_updated Дата оновлення групи в форматі ISO-8601
     */
    public function __construct(
        public int $id,
        public ?string $name,
        public ?array $name_multilang,
        public ?string $description,
        public ?array $description_multilang,
        public ?string $url,
        public ?string $image,
        public ?int $parent_id,
        public ?int $level,
        public ?int $position,
        public ?bool $has_children,
        public ?array $children,
        public ?string $date_created,
        public ?string $date_updated,
    ) {
    }

    /**
     * Створює екземпляр GroupDto з масиву даних
     *
     * @param array $data Масив даних для створення DTO
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            name: $data['name'] ?? null,
            name_multilang: $data['name_multilang'] ?? null,
            description: $data['description'] ?? null,
            description_multilang: $data['description_multilang'] ?? null,
            url: $data['url'] ?? null,
            image: $data['image'] ?? null,
            parent_id: $data['parent_id'] ?? null,
            level: $data['level'] ?? null,
            position: $data['position'] ?? null,
            has_children: $data['has_children'] ?? null,
            children: $data['children'] ?? null,
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
            'name_multilang' => $this->name_multilang,
            'description' => $this->description,
            'description_multilang' => $this->description_multilang,
            'url' => $this->url,
            'image' => $this->image,
            'parent_id' => $this->parent_id,
            'level' => $this->level,
            'position' => $this->position,
            'has_children' => $this->has_children,
            'children' => $this->children,
            'date_created' => $this->date_created,
            'date_updated' => $this->date_updated,
        ];
    }
}