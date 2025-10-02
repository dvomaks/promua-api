<?php

namespace Dvomaks\PromuaApi\Tests;

use Illuminate\Support\Facades\Config;

class TestCaseIntegration extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Переконуємося, що встановлено реальні значення для тестування
        $this->checkApiToken();
    }

    public function getEnvironmentSetUp($app)
    {
        // Викликаємо батьківський метод для налаштування базової конфігурації
        parent::getEnvironmentSetUp($app);

        // Завантажуємо .env.testing файл, якщо він існує
        if (file_exists(__DIR__.'/../.env.testing')) {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/../', '.env.testing');
            $dotenv->safeLoad();
        }

        config()->set('promua-api.api_token', env('PROMUA_API_TOKEN', ''));
        config()->set('promua-api.base_url', env('PROMUA_BASE_URL', 'https://my.prom.ua/api/v1'));
        config()->set('promua-api.timeout', env('PROMUA_TIMEOUT', 30));
        config()->set('promua-api.language', env('PROMUA_LANGUAGE', 'uk'));
    }

    protected function checkApiToken()
    {
        if (! Config::get('promua-api.api_token')) {
            $this->markTestSkipped('PROMUA_API_TOKEN is not set for integration tests.');
        }
    }
}
