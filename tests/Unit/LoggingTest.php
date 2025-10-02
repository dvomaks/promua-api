<?php

use Dvomaks\PromuaApi\Http\PromuaApiClient;
use Illuminate\Log\LogManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mockery\Expectation;
use Mockery\MockInterface;
use Psr\Log\LoggerInterface;

test('it logs requests and responses when logging is enabled', function () {
    Config::set('promua-api.logging.enabled', true);

    Http::fake([
        'https://my.prom.ua/api/v1/test' => Http::response(['data' => 'test']),
    ]);

    // Мок для каналу 'deprecations' який використовує Laravel Testbench
    $deprecationChannelMock = Mockery::mock(LoggerInterface::class);
    $deprecationChannelMock->shouldReceive('warning');

    // Мок для LogManager щоб обробити виклики каналу 'deprecations'
    $logManagerMock = Mockery::mock(LogManager::class);
    /** @var Expectation $expectation */
    $expectation = $logManagerMock->allows('channel');
    $expectation->with('deprecations')->andReturn($deprecationChannelMock);

    // Замінюємо Log facade на мок LogManager
    Log::swap($logManagerMock);

    // Очікування для прямого виклику Log::info() з JSON-рядками
    Log::shouldReceive('info')
        ->once()
        ->withArgs(fn ($message) => str_starts_with($message, 'PromUA API Request: '))
        ->andReturnNull();
    Log::shouldReceive('info')
        ->once()
        ->withArgs(fn ($message) => str_starts_with($message, 'PromUA API Response: '))
        ->andReturnNull();

    $client = new PromuaApiClient;
    /** @noinspection PhpUnhandledExceptionInspection */
    $client->get('test');

    Http::assertSent(fn ($request) => $request->url() === 'https://my.prom.ua/api/v1/test');
});

test('it does not log requests and responses when logging is disabled', function () {
    Config::set('promua-api.logging.enabled', false);

    Http::fake([
        'https://my.prom.ua/api/v1/test' => Http::response(['data' => 'test']),
    ]);

    // Мок для каналу 'deprecations' який використовує Laravel Testbench
    $deprecationChannelMock = Mockery::mock(LoggerInterface::class);
    $deprecationChannelMock->shouldReceive('warning');

    // Мок для LogManager щоб обробити виклики каналу 'deprecations'
    $logManagerMock = Mockery::mock(LogManager::class);
    /** @var Expectation $expectation */
    $expectation = $logManagerMock->allows('channel');
    $expectation->with('deprecations')->andReturn($deprecationChannelMock);

    // Замінюємо Log facade на мок LogManager
    Log::swap($logManagerMock);

    $client = new PromuaApiClient;
    /** @noinspection PhpUnhandledExceptionInspection */
    $client->get('test');

    Http::assertSent(fn ($request) => $request->url() === 'https://my.prom.ua/api/v1/test');

    // Перевіряємо, що Log::info не викликався для наших повідомлень

    // робимо spy
    Log::spy();

    // код, який може логувати...

    /** @var MockInterface&LoggerInterface $logMock */
    $logMock = Log::getFacadeRoot();

    $logMock->shouldNotHaveReceived('info', [
        Mockery::on(fn ($m) => str_starts_with($m, 'PromUA API Request: ')),
    ]);

    $logMock->shouldNotHaveReceived('info', [
        Mockery::on(fn ($m) => str_starts_with($m, 'PromUA API Response: ')),
    ]);
});
