<?php

namespace Dvomaks\PromuaApi\Services;

use Dvomaks\PromuaApi\Dto\ProductDto;
use Dvomaks\PromuaApi\Exceptions\PromuaApiException;
use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Exception;
use Illuminate\Http\Client\ConnectionException;

/**
 * ProductsService provides methods to interact with product functionality of the Promua API.
 * It allows retrieving products list, getting products by ID or external ID, editing products,
 * importing products from file or URL, checking import status, and managing product translations.
 */
readonly class ProductsService
{
    /**
     * ProductsService constructor.
     *
     * @param  PromuaApiClient  $client  The API client used to make requests to the Promua API
     */
    public function __construct(private PromuaApiClient $client) {}

    /**
     * Get a list of products
     *
     * @param  string|null  $lastModifiedFrom  Request for items modified after the specified date. Example - `2015-04-28T12:50:34`
     * @param  string|null  $lastModifiedTo  Request for items modified before the specified date. Example - `2015-04-28T12:50:34`
     * @param  int|null  $limit  Limiting the number of items in the response
     * @param  int|null  $lastId  Limit the selection of products with identifiers no higher than the specified one
     * @param  int|null  $groupId  Group ID
     * @return ProductDto[] Array of ProductDto objects
     *
     * @throws PromuaApiException
     * @throws ConnectionException
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
     * Get a product by ID
     *
     * @param  int  $id  Product identifier
     * @return ProductDto The product data transfer object
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function getById(int $id): ProductDto
    {
        $response = $this->client->get("/products/$id");

        return ProductDto::fromArray($response);
    }

    /**
     * Get a product by external ID
     *
     * @param  string  $externalId  Product external identifier
     * @return ProductDto The product data transfer object
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function getByExternalId(string $externalId): ProductDto
    {
        $response = $this->client->get("/products/by_external_id/$externalId");

        return ProductDto::fromArray($response);
    }

    /**
     * Edit a product
     *
     * @param  array  $data  Product data
     * @return ProductDto The updated product data transfer object
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function edit(array $data): ProductDto
    {
        $response = $this->client->post('/products/edit', $data);

        return ProductDto::fromArray($response);
    }

    /**
     * Edit a product by external ID
     *
     * @param  array  $data  Product data
     * @return ProductDto The updated product data transfer object
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function editByExternalId(array $data): ProductDto
    {
        $response = $this->client->post('/products/edit_by_external_id', $data);

        return ProductDto::fromArray($response);
    }

    /**
     * TODO
     * Import products from a file
     *
     * @param  string  $filePath  Path to the file
     * @param  array  $params  Additional parameters
     * @return array Import result
     *
     * @throws Exception
     *
     * @noinspection PhpUnused
     * @noinspection PhpUnusedParameterInspection
     */
    public function importFromFile(string $filePath, array $params = []): array
    {
        // TODO: For file imports, a different approach is needed since this is multipart/form-data
        throw new Exception('Import from file not implemented yet');
    }

    /**
     * Import products from a URL
     *
     * @param  string  $url  URL to the file
     * @param  bool|null  $forceUpdate  Force update
     * @param  bool|null  $onlyAvailable  Import only available products
     * @param  string|null  $markMissingProductAs  Status for missing products (none, not_available, not_on_display, deleted)
     * @param  array|null  $updatedFields  Fields to update
     * @return array Import result
     *
     * @throws ConnectionException
     * @throws PromuaApiException
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
     * Check import status
     *
     * @param  int  $importId  Import process ID
     * @return array Import status
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function getImportStatus(int $importId): array
    {
        return $this->client->get("/products/import/status/$importId");
    }

    /**
     * Get product translation
     *
     * @param  string  $productId  Product ID
     * @param  string  $lang  Translation language
     * @return array Product translation
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function getTranslation(string $productId, string $lang): array
    {
        return $this->client->get("/products/translation/$productId", ['lang' => $lang]);
    }

    /**
     * Update product translation
     *
     * @param  array  $data  Translation data
     * @return array Update result
     *
     * @throws ConnectionException
     * @throws PromuaApiException
     */
    public function updateTranslation(array $data): array
    {
        return $this->client->put('/products/translation', $data);
    }
}
