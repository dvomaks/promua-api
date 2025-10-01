<?php

// config for Dvomaks/PromuaApi
return [
    /*
    |--------------------------------------------------------------------------
    | PromUA API Configuration
    |--------------------------------------------------------------------------
    |
    | This is the configuration file for the PromUA API package.
    | You can set your API token, base URL, and other settings here.
    |
    */

    'api_token' => env('PROMUA_API_TOKEN', ''),

    'base_url' => env('PROMUA_BASE_URL', 'https://my.prom.ua/api/v1'),

    'timeout' => env('PROMUA_TIMEOUT', 30),

    'language' => env('PROMUA_LANGUAGE', 'uk'),

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Configure if API requests and responses should be logged.
    |
    */

    'logging' => [
        'enabled' => env('PROMUA_LOGGING_ENABLED', false),
    ],
];
