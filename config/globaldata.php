<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Global Data
    |--------------------------------------------------------------------------
    |
    | Here you can configure the global data that is automatically assigned to each
    | view. The key "all" is a place to define data that should be across the main
    | site and subsites.
    |
    | The sites array should be keyed by the site_id for the specific site you want
    | to set global data on. You can override promo groups from "all" by specifying
    | the same key. If no promo config value exists for a subsite promo group it
    | will default to the value in the all config.
    |
    | The "methods" array allows you to specify a relative namespace and method
    | to call. This method will automatically be called for you and assigned
    | to the view. This should only be used if you want to that data on
    | every page (or every page for a specific subsite).
    |
    */
    'all' => [
        'promos' => [
            'main_contact' => [
                'id' => 2908,
                'config' => 'limit:4',
            ],
            'main_social' => [
                'id' => 2907,
                'config' => null,
            ],
            'under_menu' => [
                'id' => 2909,
                'config' => 'page_id:{$page_id}',
            ],
            'hero' => [
                'id' => 3001,
                'config' => 'page_id:{$page_id}|randomize|limit:1',
            ],
            'banner' => [
                'id' => 4246,
                'config' => 'page_id:{$page_id}|first',
            ],
        ],
        'methods' => [
            '\Repositories\MenuRepository' => 'getRequestData',
            '\Repositories\PromoRepository' => 'getRequestData',
        ],
    ],
    'sites' => [
        0000 => [
            'promos' => [
                'contact' => [
                    'id' => 0000,
                    'config' => 'limit:1',
                    'merge_with_main_contact' => true,
                ],
                'social' => [
                    'id' => 0000,
                    'config' => null,
                ],
            ],
            'methods' => [],
        ],
    ],
];
