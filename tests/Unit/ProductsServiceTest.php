<?php

use Dvomaks\PromuaApi\Dto\ProductDto;
use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Dvomaks\PromuaApi\Services\ProductsService;

beforeEach(function () {
    $this->mockClient = Mockery::mock(PromuaApiClient::class);
    $this->productsService = new ProductsService($this->mockClient);
});

afterEach(function () {
    Mockery::close();
});

test('getList returns array of ProductDto', function () {
    $mockResponse = [
        'products' => [
            [
                'id' => 1,
                'name' => 'Test Product',
                'price' => 100.00,
                'status' => 'on_display',
            ],
        ],
    ];

    $this->mockClient
        ->shouldReceive('get')
        ->with('/products/list', [])
        ->andReturn($mockResponse);

    $result = $this->productsService->getList();

    expect($result)->toBeArray();
    expect($result[0])->toBeInstanceOf(ProductDto::class);
    expect($result[0]->id)->toBe(1);
    expect($result[0]->name)->toBe('Test Product');
});

test('getList with parameters returns array of ProductDto', function () {
    $lastModifiedFrom = '2023-01-01T00:00:00';
    $lastModifiedTo = '2023-12-31T23:59:59';
    $limit = 10;
    $lastId = 100;
    $groupId = 5;

    $mockResponse = [
        'products' => [
            [
                'id' => 2,
                'name' => 'Test Product 2',
                'price' => 200.00,
                'status' => 'on_display',
            ],
        ],
    ];

    $this->mockClient
        ->shouldReceive('get')
        ->with('/products/list', [
            'last_modified_from' => $lastModifiedFrom,
            'last_modified_to' => $lastModifiedTo,
            'limit' => $limit,
            'last_id' => $lastId,
            'group_id' => $groupId,
        ])
        ->andReturn($mockResponse);

    $result = $this->productsService->getList($lastModifiedFrom, $lastModifiedTo, $limit, $lastId, $groupId);

    expect($result)->toBeArray();
    expect($result[0])->toBeInstanceOf(ProductDto::class);
    expect($result[0]->id)->toBe(2);
    expect($result[0]->name)->toBe('Test Product 2');
});

test('getById returns ProductDto', function () {
    $productId = 1;
    $mockResponse = [
        'id' => $productId,
        'name' => 'Test Product',
        'price' => 100.00,
        'status' => 'on_display',
    ];

    $this->mockClient
        ->shouldReceive('get')
        ->with("/products/{$productId}")
        ->andReturn($mockResponse);

    $result = $this->productsService->getById($productId);

    expect($result)->toBeInstanceOf(ProductDto::class);
    expect($result->id)->toBe($productId);
    expect($result->name)->toBe('Test Product');
});

test('getByExternalId returns ProductDto', function () {
    $externalId = 'EXT-123';
    $mockResponse = [
        'id' => 1,
        'name' => 'Test Product',
        'external_id' => $externalId,
        'price' => 100.00,
        'status' => 'on_display',
    ];

    $this->mockClient
        ->shouldReceive('get')
        ->with("/products/by_external_id/{$externalId}")
        ->andReturn($mockResponse);

    $result = $this->productsService->getByExternalId($externalId);

    expect($result)->toBeInstanceOf(ProductDto::class);
    expect($result->external_id)->toBe($externalId);
    expect($result->name)->toBe('Test Product');
});

test('edit returns ProductDto', function () {
    $productData = [
        'id' => 1,
        'name' => 'Updated Product',
        'price' => 150.00,
        'status' => 'on_display',
    ];

    $this->mockClient
        ->shouldReceive('post')
        ->with('/products/edit', $productData)
        ->andReturn($productData);

    $result = $this->productsService->edit($productData);

    expect($result)->toBeInstanceOf(ProductDto::class);
    expect($result->id)->toBe(1);
    expect($result->name)->toBe('Updated Product');
});

test('editByExternalId returns ProductDto', function () {
    $productData = [
        'id' => 'EXT-123',
        'name' => 'Updated Product',
        'price' => 150.00,
        'status' => 'on_display',
    ];

    // Відповідь API буде мати числовий ID, оскільки після обробки на сервері
    // зовнішній ID зберігається в іншому полі, а в полі id повертається внутрішній числовий ID
    $responseData = [
        'id' => 123,
        'external_id' => 'EXT-123',
        'name' => 'Updated Product',
        'price' => 150.00,
        'status' => 'on_display',
    ];

    $this->mockClient
        ->shouldReceive('post')
        ->with('/products/edit_by_external_id', $productData)
        ->andReturn($responseData);

    $result = $this->productsService->editByExternalId($productData);

    expect($result)->toBeInstanceOf(ProductDto::class);
    expect($result->id)->toBe(123);
    expect($result->external_id)->toBe('EXT-123');
    expect($result->name)->toBe('Updated Product');
});

test('importFromUrl returns array', function () {
    $url = 'https://example.com/products.csv';
    $params = [
        'url' => $url,
        'force_update' => true,
        'only_available' => false,
        'mark_missing_product_as' => 'not_available',
        'updated_fields' => ['price', 'presence'],
    ];

    $mockResponse = [
        'status' => 'success',
        'import_id' => 12345,
    ];

    $this->mockClient
        ->shouldReceive('post')
        ->with('/products/import_url', $params)
        ->andReturn($mockResponse);

    $result = $this->productsService->importFromUrl($url, true, false, 'not_available', ['price', 'presence']);

    expect($result)->toBeArray();
    expect($result['status'])->toBe('success');
    expect($result['import_id'])->toBe(12345);
});

test('getImportStatus returns array', function () {
    $importId = 12345;
    $mockResponse = [
        'status' => 'completed',
        'processed_count' => 100,
        'errors_count' => 0,
    ];

    $this->mockClient
        ->shouldReceive('get')
        ->with("/products/import/status/{$importId}")
        ->andReturn($mockResponse);

    $result = $this->productsService->getImportStatus($importId);

    expect($result)->toBeArray();
    expect($result['status'])->toBe('completed');
    expect($result['processed_count'])->toBe(100);
});

test('getTranslation returns array', function () {
    $productId = 'PROD-123';
    $lang = 'uk';
    $mockResponse = [
        'name' => 'Тестовий продукт',
        'description' => 'Опис тестового продукту',
    ];

    $this->mockClient
        ->shouldReceive('get')
        ->with("/products/translation/{$productId}", ['lang' => $lang])
        ->andReturn($mockResponse);

    $result = $this->productsService->getTranslation($productId, $lang);

    expect($result)->toBeArray();
    expect($result['name'])->toBe('Тестовий продукт');
});

test('updateTranslation returns array', function () {
    $translationData = [
        'id' => 'PROD-123',
        'name' => 'Updated Name',
        'description' => 'Updated Description',
        'lang' => 'uk',
    ];

    $mockResponse = [
        'status' => 'success',
    ];

    $this->mockClient
        ->shouldReceive('put')
        ->with('/products/translation', $translationData)
        ->andReturn($mockResponse);

    $result = $this->productsService->updateTranslation($translationData);

    expect($result)->toBeArray();
    expect($result['status'])->toBe('success');
});
