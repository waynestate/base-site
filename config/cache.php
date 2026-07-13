<?php

return [

    'prefix' => null,

    'ttl' => env('TTL'),

    'stale_ttl' => env('CACHE_STALE_TTL', 604800),

];
