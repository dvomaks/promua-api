<?php

namespace Dvomaks\PromuaApi\Dto;

/**
 * DTO для групи в системі PromUA
 *
 * Цей клас використовується для представлення даних групи з API PromUA.
 * Містить інформацію про ідентифікатор групи, назву, опис, зображення та інші властивості.
 */
class GroupDto
{
    /**
     * @param int $id Унікальний ідентифікатор групи
     * @param string|null $name Назва групи
     * @param array|null $name_multilang Переклади назви групи
     * @param string|null $description Опис групи
     * @param array|null $description_multilang Переклади опису групи
     * @param string|null $image URL-адреса зображення групи
     * @param int|null $parent_group_id Ідентифікатор батьківської групи
     */
    public function __construct(
        public int $id,
        public ?string $name,
        public ?array $name_multilang,
        public ?string $description,
        public ?array $description_multilang,
        public ?string $image,
        public ?int $parent_group_id,
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
            image: $data['image'] ?? null,
            parent_group_id: $data['parent_group_id'] ?? null,
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
            'image' => $this->image,
            'parent_group_id' => $this->parent_group_id,
        ];
    }
}