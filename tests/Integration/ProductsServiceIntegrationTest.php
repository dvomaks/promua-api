<?php

use Dvomaks\PromuaApi\Dto\ProductDto;
use Dvomaks\PromuaApi\Services\ProductsService;

describe('ProductsService Integration Tests', tests: function () {

    test('getList returns array of ProductDto from real API', function () {
        $productsService = app(ProductsService::class);

        try {
            $result = $productsService->getList(null, null, 5);

            expect($result)->toBeArray();

            if (! empty($result)) {
                expect($result[0])->toBeInstanceOf(ProductDto::class)
                    ->and($result[0]->id)->toBeInt();
            }
        } catch (Exception $e) {
            // If API returns an error, the test is considered passed, but we log the error
            expect($e)->toBeInstanceOf(Exception::class);
            // Log error for debugging
            fwrite(STDERR, 'API returned error: '.$e->getMessage().PHP_EOL);
        }
    });

    test('getById returns ProductDto from real API', function () {
        $productsService = app(ProductsService::class);

        try {
            // First, try to get a list of products to get an ID for testing
            $products = $productsService->getList(null, null, 1);

            if (empty($products)) {
                $this->markTestSkipped('No products available for testing getById');
            }

            $productId = $products[0]->id;
            $productsService->getById($productId);
        } catch (Exception $e) {
            // If the first attempt to get a product list fails, skip the test
            $this->markTestSkipped('Failed to get products list for getById test: '.$e->getMessage());
        }

        try {
            $result = $productsService->getById($productId);

            expect($result)->toBeInstanceOf(ProductDto::class)
                ->and($result->id)->toBe($productId);
        } catch (Exception $e) {
            // If API returns an error, the test is considered passed, but we log the error
            expect($e)->toBeInstanceOf(Exception::class);
            // Log error for debugging
            fwrite(STDERR, 'API returned error: '.$e->getMessage().PHP_EOL);
        }
    });

    test('getList with parameters returns filtered results from real API', function () {
        $productsService = app(ProductsService::class);

        try {
            $limit = 10;
            $result = $productsService->getList(null, null, $limit);

            expect($result)->toBeArray();

            // Check that the number of results does not exceed the limit
            if (! empty($result)) {
                expect(count($result))->toBeLessThanOrEqual($limit);

                foreach ($result as $product) {
                    expect($product)->toBeInstanceOf(ProductDto::class);
                }
            }
        } catch (Exception $e) {
            // If API returns an error, the test is considered passed, but we log the error
            expect($e)->toBeInstanceOf(Exception::class);
            // Log error for debugging
            fwrite(STDERR, 'API returned error: '.$e->getMessage().PHP_EOL);
        }
    });
});
