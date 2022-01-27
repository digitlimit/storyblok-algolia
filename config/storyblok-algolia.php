<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Debug mode
    |--------------------------------------------------------------------------
    |
    | This will enable the debug mode, which will dump data in the laravel log.
    | Useful for debugging purposes and viewing data sent from the Storyblok
    */
    'debug' => env('STORYBLOK_ALGOLIA_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Storyblok Personal access token
    |--------------------------------------------------------------------------
    |
    | Enter your Storyblok Personal access token to access their management API
    |
    */
    'oauth_token' => env('STORYBLOK_OAUTH_TOKEN', null),

    /*
    |--------------------------------------------------------------------------
    | Enable caching
    |--------------------------------------------------------------------------
    |
    | Enable caching the Storyblok API response.
    |
    */
    'cache' => env('STORYBLOK_CACHE', true),

    /*
    |--------------------------------------------------------------------------
    | Cache path
    |--------------------------------------------------------------------------
    |
    | Cache path is enabled
    |
    */
    'cache_path' => storage_path('storyblok/cache'),

    /*
    |--------------------------------------------------------------------------
    | Cache duration
    |--------------------------------------------------------------------------
    |
    | Specifies how many minutes to cache responses from Storkyblok for.
    |
    */
    'cache_duration' => env('STORYBLOK_DURATION', '60'),

    /*
    |--------------------------------------------------------------------------
    | Webhook secret
    |--------------------------------------------------------------------------
    |
    | Webhook from space settings
    | https://www.storyblok.com/docs/guide/in-depth/webhooks
    |
    */
    'webhook_secret' => env('STORYBLOK_WEBHOOK_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Storyblok webhook endpoint
    |--------------------------------------------------------------------------
    |
    | This is the endpoint that Storyblok will call when a webhook is triggered.
    | If this is set to null, we will not register any routes for webhooks, means 
    | you will have to register your own routes for webhooks.
    |
    */
    'webhook_url' => '/webhook',

    'webhook_enabled' => env('STORYBLOK_WEBHOOK_ENABLED', true),

    'search_url' => '/search',

    'search_enabled' => env('STORYBLOK_SEARCH_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Per page
    |--------------------------------------------------------------------------
    |
    | Record per page
    |
    */
    'per_page' => 100,

    /*
    |--------------------------------------------------------------------------
    | Algolia Application ID
    |--------------------------------------------------------------------------
    |
    | The Application ID is used by the client to authenticate with the Algolia API.
    |
    */
    'id' => env('ALGOLIA_APP_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Algolia API Secret
    |--------------------------------------------------------------------------
    |
    | The API Secret is used by the client to authenticate with the Algolia API.
    |
    */
    'secret' => env('ALGOLIA_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Algolia cache expiration
    |--------------------------------------------------------------------------
    |
    | The cache expiration is used to set the duration of the cache.
    |
    */
    'cache_expire' => env('ALGOLIA_CACHE_EXPIRE', 60),
];
