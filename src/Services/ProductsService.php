<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Dvomaks\PromuaApi\Dto\ProductDto;

class ProductsService
{
    public function __construct(
        protected PromuaApiClient $client
    ) {
    }

    /**
     * Отримує список продуктів
     *
     * @param string|null $lastModifiedFrom Request for items modified after the specified date. Example - `2015-04-28T12:50:34`.
     * @param string|null $lastModifiedTo Request for items modified before the specified date. Example - `2015-04-28T12:50:34`.
     * @param int|null $limit Limiting the number of items in the response.
     * @param int|null $lastId Limit the selection of products with identifiers no higher than the specified one.
     * @param int|null $groupId Group ID.
     * @return array Масив ProductDto
     */
    public function getList(
        ?string $lastModifiedFrom = null,
        ?string $lastModifiedTo = null,
        ?int $limit = null,
        ?int $lastId = null,
        ?int $groupId = null
    ): array {
        $params = array_filter([
            'last_modified_from' => $lastModifiedFrom,
            'last_modified_to' => $lastModifiedTo,
            'limit' => $limit,
            'last_id' => $lastId,
            'group_id' => $groupId,
        ]);
        
        $response = $this->client->get('/products/list', $params);
        
        $products = [];
        if (isset($response['products']) && is_array($response['products'])) {
            foreach ($response['products'] as $productData) {
                $products[] = ProductDto::fromArray($productData);
            }
        }
        
        return $products;
    }

    /**
     * Отримує продукт за ідентифікатором
     * 
     * @param int $id Ідентифікатор продукту
     * @return ProductDto
     */
    public function getById(int $id): ProductDto
    {
        $response = $this->client->get("/products/{$id}");
        
        return ProductDto::fromArray($response);
    }

    /**
     * Отримує продукт за зовнішнім ідентифікатором
     * 
     * @param string $externalId Зовнішній ідентифікатор продукту
     * @return ProductDto
     */
    public function getByExternalId(string $externalId): ProductDto
    {
        $response = $this->client->get("/products/by_external_id/{$externalId}");
        
        return ProductDto::fromArray($response);
    }

    /**
     * Редагує продукт
     *
     * @param array $data Дані продукту
     * @return ProductDto
     */
    public function edit(array $data): ProductDto
    {
        $response = $this->client->post('/products/edit', $data);
        
        return ProductDto::fromArray($response);
    }

    /**
     * Редагує продукт за зовнішнім ідентифікатором
     *
     * @param array $data Дані продукту
     * @return ProductDto
     */
    public function editByExternalId(array $data): ProductDto
    {
        $response = $this->client->post('/products/edit_by_external_id', $data);
        
        return ProductDto::fromArray($response);
    }

    /**
     * Імпортує продукти з файлу
     *
     * @param string $filePath Шлях до файлу
     * @param array $params Додаткові параметри
     * @return array Результат імпорту
     */
    public function importFromFile(string $filePath, array $params = []): array
    {
        // TODO: Для імпорту файлів потрібно використовувати інший підхід, оскільки це multipart/form-data
        throw new \Exception('Import from file not implemented yet');
    }

    /**
     * Імпортує продукти за посиланням
     *
     * @param string $url Посилання на файл
     * @param bool|null $forceUpdate Примусове оновлення
     * @param bool|null $onlyAvailable Імпорт тільки товарів в наявності
     * @param string|null $markMissingProductAs Статус для відсутніх продуктів (none, not_available, not_on_display, deleted)
     * @param array|null $updatedFields Поля для оновлення
     * @return array Результат імпорту
     */
    public function importFromUrl(
        string $url,
        ?bool $forceUpdate = null,
        ?bool $onlyAvailable = null,
        ?string $markMissingProductAs = null,
        ?array $updatedFields = null
    ): array {
        $params = array_filter([
            'url' => $url,
            'force_update' => $forceUpdate,
            'only_available' => $onlyAvailable,
            'mark_missing_product_as' => $markMissingProductAs,
            'updated_fields' => $updatedFields,
        ], function ($value) {
            return $value !== null;
        });
        
        return $this->client->post('/products/import_url', $params);
    }

    /**
     * Перевіряє статус імпорту
     *
     * @param int $importId ID процесу імпорту
     * @return array Статус імпорту
     */
    public function getImportStatus(int $importId): array
    {
        return $this->client->get("/products/import/status/{$importId}");
    }

    /**
     * Отримує переклад продукту
     *
     * @param string $productId ID продукту
     * @param string $lang Мова перекладу
     * @return array Переклад продукту
     */
    public function getTranslation(string $productId, string $lang): array
    {
        return $this->client->get("/products/translation/{$productId}", ['lang' => $lang]);
    }

    /**
     * Оновлює переклад продукту
     *
     * @param array $data Дані перекладу
     * @return array Результат оновлення
     */
    public function updateTranslation(array $data): array
    {
        return $this->client->put('/products/translation', $data);
    }
}