<?php

use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Illuminate\Log\LogManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

test('it logs requests and responses when logging is enabled', function () {
    Config::set('promua-api.logging.enabled', true);

    Http::fake([
        'https://my.prom.ua/api/v1/test' => Http::response(['data' => 'test'], 200),
    ]);

    // Мок для каналу 'deprecations' який використовує Laravel Testbench
    $deprecationChannelMock = Mockery::mock(LoggerInterface::class);
    $deprecationChannelMock->shouldReceive('warning')->andReturnNull();

    // Мок для LogManager щоб обробити виклики каналу 'deprecations'
    $logManagerMock = Mockery::mock(LogManager::class);
    $logManagerMock->shouldReceive('channel')
        ->with('deprecations')
        ->andReturn($deprecationChannelMock);

    // Замінюємо Log facade на мок LogManager
    Log::swap($logManagerMock);

    // Очікування для прямого виклику Log::info()
    Log::shouldReceive('info')
        ->once()
        ->with('PromUA API Request', Mockery::type('array'))
        ->andReturnNull();
    Log::shouldReceive('info')
        ->once()
        ->with('PromUA API Response', Mockery::type('array'))
        ->andReturnNull();

    $client = new PromuaApiClient;
    $result = $client->get('test');

    Http::assertSent(fn ($request) => $request->url() === 'https://my.prom.ua/api/v1/test');
});

test('it does not log requests and responses when logging is disabled', function () {
    Config::set('promua-api.logging.enabled', false);

    Http::fake([
        'https://my.prom.ua/api/v1/test' => Http::response(['data' => 'test'], 200),
    ]);

    // Мок для каналу 'deprecations' який використовує Laravel Testbench
    $deprecationChannelMock = Mockery::mock(LoggerInterface::class);
    $deprecationChannelMock->shouldReceive('warning')->andReturnNull();

    // Мок для LogManager щоб обробити виклики каналу 'deprecations'
    $logManagerMock = Mockery::mock(LogManager::class);
    $logManagerMock->shouldReceive('channel')
        ->with('deprecations')
        ->andReturn($deprecationChannelMock);

    // Замінюємо Log facade на мок LogManager
    Log::swap($logManagerMock);

    $client = new PromuaApiClient;
    $result = $client->get('test');

    Http::assertSent(fn ($request) => $request->url() === 'https://my.prom.ua/api/v1/test');

    // Перевіряємо, що Log::info не викликався взагалі
    Log::shouldNotHaveReceived('info');
});
