<?php

return [

    'default' => env('CACHE_STORE', env('CACHE_DRIVER', 'file')),

    'prefix' => null,

    'ttl' => env('TTL'),

    'stale_ttl' => env('CACHE_STALE_TTL', 604800),

];
