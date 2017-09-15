<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */
    'env' => env('APP_ENV'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */
    'debug' => env('APP_DEBUG'),

    /*
    |--------------------------------------------------------------------------
    | WSU API key - Waynestate\Api\Connector
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
    | Google Analytics Code
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
    | config option app.top_menu_enabled is true, then the homepage menu
    | will automatically be hidden.
    |
    */
    'homepage_menu_enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Hero Contained
    |--------------------------------------------------------------------------
    |
    | Force the hero image to be contained within the content area of the page.
    | If set to false the hero image will expand 100% across the top of the
    | site if it is not found in the menu.
    |
    */
    'hero_contained' => true,

    /*
    |--------------------------------------------------------------------------
    | Hero Text Enabled
    |--------------------------------------------------------------------------
    |
    | This enables the hero image to have excerpt text and a view more link.
    | You can also specify which controllers you want this to work on by
    | adding to the array. By default only the homepage controller
    | is allowed to have this functionality.
    |
    */
    'hero_text_enabled' => false,
    'hero_text_controllers' => ['HomepageController'],
    'hero_text_more' => 'View more',

    /*
    |--------------------------------------------------------------------------
    | Sessions
    |--------------------------------------------------------------------------
    |
    | Enable sessions by calling session_start in the boostrap/app.php file.
    |
    */
    'sessions_enable' => false,

    /*
    |--------------------------------------------------------------------------
    | Surtitle
    |--------------------------------------------------------------------------
    |
    | Title to be shown above the main title of the site you are on. By default
    | it will link back to "/" which is the main homepage.
    |
    */
    'surtitle' => null,
    'surtitle_main_site_enabled' => false,

    /*
    |--------------------------------------------------------------------------
    | Profile view back url
    |--------------------------------------------------------------------------
    |
    | Back URL to use when viewing a Individual Profile view in place for the
    | "Return to Listing" link.
    |
    */
    'profile_default_back_url' => '/profiles/',
];
