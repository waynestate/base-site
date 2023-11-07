<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TopicController;

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
    | Google Tag Manager
    |--------------------------------------------------------------------------
    |
    | The GTM code can be obtained at https://tagmanager.google.com/. There
    | is no default container. Ensure the site domain has been added to
    | the lookup table of the main container or has its own.
    |
    */
    'gtm_code' => 'GTM-NCBVKQ2',

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
    | Top Menu Label for Off-canvas
    |--------------------------------------------------------------------------
    |
    | When there is a top menu and a local page menu, this is the label the
    | will be give to the top menu when the off-canvas menu is expanded.
    | It can be changed here based on context, ex. "CLAS menu".
    |
    */
    'top_menu_label' => 'Main menu',

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
    | People Parent Group
    |--------------------------------------------------------------------------
    |
    | This will limit the groups displayed to only the children groups under
    | this ID. Typically the group is called "Departments". If all desired
    | groups are added to the root then leave this value as 0.
    |
    */
    'people_parent_group_id' => 0,

    /*
    |--------------------------------------------------------------------------
    | Default Meta Image
    |--------------------------------------------------------------------------
    |
    | Here you can setup a default meta image.
    |
    */
    'meta_image' =>'https://assets.wayne.edu/images/opengraph/wsu-social-share.png',
    'meta_image_alt' =>'Wayne State University shield with Warrior Strong text above',

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
    | Twitter Card
    |--------------------------------------------------------------------------
    |
    | This will output the appropriate meta tags in the head of the document.
    |
    */
    'twitter_handle' => '@waynestate',

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
    | If you change any of the route paths from the default value you will
    | need to also change the CMS page, styleguide page, and styleguide
    | menu path to coincide with your new path. Below are the files
    | you would need to change in the styleguide.
    |
    | /styleguide/Pages/News.php -> value of `news_listing_route`
    | /styleguide/Pages/NewsView.php -> value of `news_view_route`
    | /styleguide/Pages/NewsTopic.php -> value of `news_listing_route + `news_topic_route`
    | /styleguide/Pages/NewsTopics.php -> value of `news_view_route` + `news_topics_route`
    |
    */
    'news_listing_route' => 'news',
    'news_view_route' => 'news',
    'news_topic_route' => 'topic',
    'news_topics_route' => 'topics',
    'news_topics_text' => 'Filter by topic',
    'news_topics_controller' => TopicController::class,
    'news_controller' => ArticleController::class,

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
    | The "callbacks" array allows you to specify a relative namespace and method
    | to call. This method will automatically be called for you and assigned
    | to the view. This should only be used if you want to that data on
    | every page (or every page for a specific subsite).
    |
    */
    'global' => [
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
                'main_under_menu' => [
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
            'callbacks' => [
                '\Repositories\MenuRepository@getRequestData',
                '\Repositories\PromoRepository@getRequestData',
            ],
        ],
        'sites' => [
            // 0 => [
            //     'promos' => [
            //         'contact' => [
            //             'id' => 0,
            //             'config' => 'limit:1',
            //             'merge_with_main_contact' => true,
            //         ],
            //         'social' => [
            //             'id' => 0,
            //             'config' => null,
            //         ],
            //         'under_menu' => [
            //             'id' => 6022,
            //             'config' => 'page_id:{$page_id}',
            //             'merge_with_main_under_menu' => false,
            //         ],
            //     ],
            //     'callbacks' => [],
            //     'surtitle_disabled' => null,
            // ],
        ],
    ],
];
