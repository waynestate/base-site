<?php

return [

    /*
    |--------------------------------------------------------------------------
    | WSU API Key - Waynestate\Api\Connector
    |--------------------------------------------------------------------------
    |
    | Create an API key by going to http://api.wayne.edu/tools/test/raw.php
    | The value returned should be added to the .env file on the
    | dev and production servers.
    |
    */
    'wsu_api_key' => env('WSUAPI_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Google Analytics
    |--------------------------------------------------------------------------
    |
    | The UA- code can be obtained at https://www.google.com/analytics/. The
    | name is a unique identifier, typically the domain name. By default we
    | also include the global allWayneState GA code.
    |
    */
    'ga_code' => 'UA-',
    'ga_code_all_wsu' => 'UA-',
    'ga_name' => 'Base',

    /*
    |--------------------------------------------------------------------------
    | Top Menu Enabled
    |--------------------------------------------------------------------------
    |
    | This enables the first level of the menu to be horizontal across the
    | top bar of the site.
    |
    */
    'top_menu_enabled' => false,

    /*
    |--------------------------------------------------------------------------
    | Top Menu Override
    |--------------------------------------------------------------------------
    |
    | Setting an ID will force the top menu to always use the specified menu
    | rather than the menu that is assigned to the page you are on. This
    | is useful for when subsites need to use the parents menu.
    |
    */
    'top_menu_id' => null,

    /*
    |--------------------------------------------------------------------------
    | Homepage Menu Enabled
    |--------------------------------------------------------------------------
    |
    | This enables the first level of the menu to show on the homepage. If the
    | config option base.top_menu_enabled is true, then the homepage menu
    | will automatically be hidden.
    |
    */
    'homepage_menu_enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Hero Full Width
    |--------------------------------------------------------------------------
    |
    | This enables hero images to span 100% across the top of the site. You
    | can specify which controllers you want this to work on by adding to
    | the array. If a controller is not listed it will be contained
    | within the content-area. If a page isn't in the menu and top
    | menu is enabled then the controller will automatically act
    | as if it was in this array.
    |
    */
    'hero_full_controllers' => [],

    /*
    |--------------------------------------------------------------------------
    | Hero Rotating
    |--------------------------------------------------------------------------
    |
    | This enables the hero image to have arrows to rotate through them, if
    | the page has more than one hero image assigned. You can specify
    | which controllers you want this to work on by adding to the
    | array.
    |
    */
    'hero_rotating_controllers' => [],
    'hero_rotating_limit' => 3,

    /*
    |--------------------------------------------------------------------------
    | Hero Text
    |--------------------------------------------------------------------------
    |
    | This enables the hero image to have excerpt text and a view more link.
    | You can also specify which controllers you want this to work on by
    | adding to the array.
    |
    */
    'hero_text_controllers' => [],
    'hero_text_more' => 'View more',

    /*
    |--------------------------------------------------------------------------
    | Surtitle
    |--------------------------------------------------------------------------
    |
    | Title to be shown above the main title of the site you are on. By default
    | it will link back to '/' which homepage of the current domain.
    |
    */
    'surtitle' => null,
    'surtitle_main_site_enabled' => false,
    'surtitle_url' => '/',

    /*
    |--------------------------------------------------------------------------
    | Profile View Back Url
    |--------------------------------------------------------------------------
    |
    | Back URL to use when viewing a Individual Profile view in place for the
    | "Return to Listing" link.
    |
    */
    'profile_default_back_url' => '/profiles/',

    /*
    |--------------------------------------------------------------------------
    | Profile Parent Group
    |--------------------------------------------------------------------------
    |
    | This will limit the groups displayed to only the children groups under
    | this ID. Typically the group is called "Departments". If all desired
    | groups are added to the root then leave this value as 0.
    |
    */
    'profile_parent_group_id' => 0,

    /*
    |--------------------------------------------------------------------------
    | Facebook Open Graph
    |--------------------------------------------------------------------------
    |
    | Here you can setup open graph tied to a specific application. This will
    | output the appropriate meta tags in the head of the document.
    |
    */
    'facebook_profile_id' => null,
    'facebook_app_id' => null,

    /*
    |--------------------------------------------------------------------------
    | Full Width Content Area
    |--------------------------------------------------------------------------
    |
    | Here you can specify in an array which controllers should have a full
    | width content area. This way you can have things that span
    | horizontally across the whole site like a background
    | color or image.
    |
    */
    'full_width_controllers' => [],

    /*
    |--------------------------------------------------------------------------
    | News
    |--------------------------------------------------------------------------
    |
    | Here you can configure the news area. No ending slash for route paths.
    | If you change a route path from the default value you will need to
    | also change the CMS pages and styleguide menu path to coincide
    | with your new path.
    |
    */
    'news_listing_route' => 'news',
    'news_view_route' => 'news',
    'news_category_route' => 'category',
    'news_all_text' => 'All categories',

    /*
    |--------------------------------------------------------------------------
    | Global Promotion Groups
    |--------------------------------------------------------------------------
    |
    | Here you can configure the global promotional groups. Subsites are keyed
    | by site_id and allow for an optional config value. If no config value
    | exists for a subsite promo group it will default to the main config.
    | Subsite will also use the main promo roups unless a site_id key
    | exists.
    |
    */
    'global_promos' => [
        'main' => [
            'contact' => [
                'id' => 2908,
                'config' => 'limit:3',
            ],
            'social' => [
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
        'subsites' => [
            // 0000 => [
            //     'contact' => [
            //         'id' => 0000,
            //         'override' => false, // Override footer with only this contact group
            //     ],
            // ],
        ],
    ],
];
