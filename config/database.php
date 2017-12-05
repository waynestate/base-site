<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        /*
        |--------------------------------------------------------------------------
        | Cache storage
        |--------------------------------------------------------------------------
        |
        | The cache storage will use database 1 as to not conflict with
        | PHPREDIS_SESSION's being set.
        |
        */
        'client' => 'predis',

        'default' => [
            'database' => 1,
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
        ],

        'sessions' => [
            'database' => 0,
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
        ],

        /*
        |--------------------------------------------------------------------------
        | Redis prefix
        |--------------------------------------------------------------------------
        |
        | The prefix is used to easily identify data in the database. Running
        | php artisan cache:clear however will clear ALL cache for the
        | default Redis database 1.
        |
        */
        'options' => [
            'prefix' => str_slug(env('APP_NAME', 'laravel')).':',
        ],
    ],
];
