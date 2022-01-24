<?php

return [
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
