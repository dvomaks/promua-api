<?php

namespace Dvomaks\PromuaApi\Dto;

/**
 * DTO для продукту в системі PromUA
 *
 * Цей клас використовується для представлення даних продукту з API PromUA.
 * Містить інформацію про ідентифікатор продукту, назву, ціну, наявність, групу, категорію та інші властивості, вказані в документації API.
 */
class ProductDto
{
    /**
     * @param int $id Унікальний ідентифікатор продукту
     * @param string|null $external_id Унікальний (зовнішньої системи) ідентифікатор продукту
     * @param string $name Назва продукту
     * @param array|null $name_multilang Багатомовна назва продукту
     * @param string|null $sku Артикул товару
     * @param string|null $keywords Ключові слова товару
     * @param string|null $description Опис товару
     * @param array|null $description_multilang Багатомовний опис товару
     * @param string $selling_type Тип товару (retail, wholesale, universal, service)
     * @param string $presence Наявність товару (available, not_available, order, service)
     * @param bool|null $in_stock Статус «В наявності»
     * @param array|null $regions Де знаходиться товар
     * @param float|null $price Ціна товару
     * @param float|null $minimum_order_quantity Мінімальна кількість товарів в замовленні
     * @param array|null $discount Знижка
     * @param string|null $currency Валюта товару
     * @param array|null $group Група товару
     * @param array|null $category Категорія товару
     * @param array|null $prices Сітка гуртових цін
     * @param string|null $main_image Посилання на головне зображення товару
     * @param array|null $images Додаткові зображення товару
     * @param string|null $status Статус товару (on_display, draft, deleted, not_on_display, editing_required, approval_pending, deleted_by_moderator)
     * @param int|null $quantity_in_stock Залишок продукту на складі
     * @param string|null $measure_unit Одиниця вимірювання
     * @param bool|null $is_variation Чи є товар різновидом
     * @param int|null $variation_base_id Ідентифікатор базового товару
     * @param int|null $variation_group_id Ідентифікатор групи різновидів
     */
    public function __construct(
        public int $id,
        public ?string $external_id,
        public string $name,
        public ?array $name_multilang,
        public ?string $sku,
        public ?string $keywords,
        public ?string $description,
        public ?array $description_multilang,
        public string $selling_type,
        public string $presence,
        public ?bool $in_stock,
        public ?array $regions,
        public ?float $price,
        public ?float $minimum_order_quantity,
        public ?array $discount,
        public ?string $currency,
        public ?array $group,
        public ?array $category,
        public ?array $prices,
        public ?string $main_image,
        public ?array $images,
        public ?string $status,
        public ?int $quantity_in_stock,
        public ?string $measure_unit,
        public ?bool $is_variation,
        public ?int $variation_base_id,
        public ?int $variation_group_id,
    ) {
    }

    /**
     * Створює екземпляр ProductDto з масиву даних
     *
     * @param array $data Масив даних для створення DTO
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            external_id: $data['external_id'] ?? null,
            name: $data['name'] ?? '',
            name_multilang: $data['name_multilang'] ?? null,
            sku: $data['sku'] ?? null,
            keywords: $data['keywords'] ?? null,
            description: $data['description'] ?? null,
            description_multilang: $data['description_multilang'] ?? null,
            selling_type: $data['selling_type'] ?? 'universal',
            presence: $data['presence'] ?? 'available',
            in_stock: $data['in_stock'] ?? null,
            regions: $data['regions'] ?? null,
            price: $data['price'] ?? null,
            minimum_order_quantity: $data['minimum_order_quantity'] ?? null,
            discount: $data['discount'] ?? null,
            currency: $data['currency'] ?? null,
            group: $data['group'] ?? null,
            category: $data['category'] ?? null,
            prices: $data['prices'] ?? null,
            main_image: $data['main_image'] ?? null,
            images: $data['images'] ?? null,
            status: $data['status'] ?? null,
            quantity_in_stock: $data['quantity_in_stock'] ?? null,
            measure_unit: $data['measure_unit'] ?? null,
            is_variation: $data['is_variation'] ?? null,
            variation_base_id: $data['variation_base_id'] ?? null,
            variation_group_id: $data['variation_group_id'] ?? null,
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
            'external_id' => $this->external_id,
            'name' => $this->name,
            'name_multilang' => $this->name_multilang,
            'sku' => $this->sku,
            'keywords' => $this->keywords,
            'description' => $this->description,
            'description_multilang' => $this->description_multilang,
            'selling_type' => $this->selling_type,
            'presence' => $this->presence,
            'in_stock' => $this->in_stock,
            'regions' => $this->regions,
            'price' => $this->price,
            'minimum_order_quantity' => $this->minimum_order_quantity,
            'discount' => $this->discount,
            'currency' => $this->currency,
            'group' => $this->group,
            'category' => $this->category,
            'prices' => $this->prices,
            'main_image' => $this->main_image,
            'images' => $this->images,
            'status' => $this->status,
            'quantity_in_stock' => $this->quantity_in_stock,
            'measure_unit' => $this->measure_unit,
            'is_variation' => $this->is_variation,
            'variation_base_id' => $this->variation_base_id,
            'variation_group_id' => $this->variation_group_id,
        ];
    }
}