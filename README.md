Base Template
================

| Branch | Build                                                                                                                                                               | Coverage |
---|---------------------------------------------------------------------------------------------------------------------------------------------------------------------|---
| Master | ![Master Build Status](https://github.com/waynestate/base-site/actions/workflows/build.yml/badge.svg?branch=master)                                                 | [![Coverage Status](https://coveralls.io/repos/github/waynestate/base-site/badge.svg?branch=master)](https://coveralls.io/github/waynestate/base-site?branch=master) |
| Develop | [![Develop Build Status](https://github.com/waynestate/base-site/actions/workflows/build.yml/badge.svg?branch=develop)](https://travis-ci.org/waynestate/base-site) | [![Coverage Status](https://coveralls.io/repos/github/waynestate/base-site/badge.svg?branch=develop)](https://coveralls.io/github/waynestate/base-site?branch=develop) | 

Starter repository for creating a new website. Live demo can be found at https://base.wayne.edu/.

## Features

* Backend built on [Laravel](https://laravel.com/)
* Frontend built on [Tailwind](https://tailwindcss.com/)
* Module bundling using [Webpack](https://webpack.github.io/)
* Fluent webpack API using [Laravel Mix](https://laravel.com/docs/5.6/mix)
* Zero downtime deployment using [Envoy](https://laravel.com/docs/5.6/envoy)
* Configure multiple enviorments using [PHPDotenv](https://github.com/vlucas/phpdotenv)
* SCSS support
* Automatically inject JS/CSS while developing using [BrowserSync](https://browsersync.io/)
* [100% test code coverage](https://base.wayne.edu/coverages)
* [Public API documentation](https://base.wayne.edu/api)
* Commit hook that require the following to pass:
    * Tests using [PHPUnit](https://phpunit.de/)
    * PHP linting using [Laravel Pint](https://laravel.com/docs/9.x/pint)
    * JS linting using [ESLint](http://eslint.org/)
    * CSS/SCSS linting using [Stylelint](https://stylelint.io/)
* Menus
    * Top level menu carried across all pages that follows you down the page as you scroll
    * Left menu if a page has subitems, otherwise its a full width page
    * Slideout menu that is triggered on a variable breakpoint that includes
        * The top level menu grouped together
        * Left menu
        * Under menu promotions
        * Banner promotion
* [Full styleguide](https://base.wayne.edu/styleguide) detailing out every available component using [PHP faker data](https://github.com/fzaninotto/Faker)
* [Single](https://base.wayne.edu/styleguide/hero/full) or [rotating](https://base.wayne.edu/styleguide/hero/full/rotate) hero images using [Flickity](https://flickity.metafizzy.co/)
* Automatically lightbox youtube videos using [Media Box](https://github.com/pinceladasdaweb/mediabox)
* Easy integration with a CMS by writing custom .json files to the public directory which are matched by to a route and sent to the specified controller

## Setup

1. Setup laravel homestead: http://laravel.com/docs/homestead
1. Clone the repository
1. run `make install`
1. run `make build`
1. run `make watch`
1. open https://domain.local:3000/ (for BrowserSync)

## Deployment

* Setup the following config variables in `Envoy.blade.php`
    * `$appname`
    * `$server_map`
    * `$source_repo`
    * `$deploy_basepath`
* Development: `envoy run deploy` or `make deploy`
* Production: `envoy run deploy --on="production"` or `make deployproduction`
* Any branch: `envoy run deploy --branch=feature/feature`

## Run tests

    phpunit

## Run test coverage

1. `make coverage`
2. Open the coverages/index.html file in your browser

## Check for outdated packages

    make status

## Update packages

    make update

## Configure the site

1. Open `/config/base.php`
1. Edit the options to configure the site, some values are present in the `.env` file.
1. Server specific configuration options come from the `.env` file which need to be manually created/updated on the servers the app is deployed to.

## Request a WSU API key

Email web@wayne.edu with your request.

## Adding `.env` variables
1. Add a config option to `config/base.php` called your_key using the `env()` function.
1. Using it in blade: `<script>var KEY = { API_KEY: {{ config('base.your_key' }} };</script> .`
1. Using it in PHP: `<?php $key = config('base.your_key'); ?>`
1. Add a blank entry to your local `.env.example` file for `your_key`
1. Add an entry with the actual value to your local `.env` file. 
1. Commit the .env.example file. You may want to put the actual value in the example file when necessary.
2. Once the site is deployed you will want to add the actual value to the `.env` on each server.

## Developing global data that is passed down to all views via the `$request->data` variable

1. Open the folder `/app/Repositories`.
1. Create new class and implement the interface `RequestDataRepositoryContract`.
1. Fill out the `getRequestData` method and return an array.
1. Add the callback under the site in `config/base.php`

### Developing controllers

1. Open the folder `/app/Http/Controllers/`
1. This folder contains all the selectable templates from the CMS.
1. Controllers should:
    * Dependency inject repositories into the constructor.
    * Call repositories to obtain data to send to the view.

## Developing views

1. Open `/resources/views/`
1. This folder contains all the views for the front-end using the [blade templating engine](https://laravel.com/docs/)
1. Files must be saved in the format of: `homepage.blade.php`
1. Components: Contains views that are reusable

## Pages

Pages are written from the content management system automatically. To replicate what it writes you can use the following JSON format to create pages. Example homeage: `storage/app/public/index.json`.

```
{
    "site" : {
        "id" : 1,
        "title" : "Base Site",
        "subsite-folder" : null,
        "parent" : {
            "id" : null
        }
    },
    "page" : {
        "id" : 1,
        "controller" : "HomepageController",
        "title" : "Welcome!",
        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed turpis lorem, malesuada eu tellus vel, pharetra consequat lacus. Vestibulum eu metus nec massa viverra iaculis. Pellentesque libero eros, varius non sem et, dapibus aliquam magna. Praesent ultri",
        "content" : {
            "main" : "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed turpis lorem, malesuada eu tellus vel, pharetra consequat lacus. Vestibulum eu metus nec massa viverra iaculis. Pellentesque libero eros, varius non sem et, dapibus aliquam magna.</p>"
        },
        "keywords" : "",
        "updated-at" : "",
        "canonical" : ""
    },
    "menu" : {
        "id" : 1
    },
    "data" : {

    }
}
```

## Menus

Menus are automatically pulled from the content management system. To replicate the structure you can use the following array and replace the code in `App\Repositories\MenuRepository@getAllMenus`.

```
<?php

$menus = [
    1 => [ // The menu_id specified from the .json file
        1 => [ // First menu item
            'menu_item_id' => '1', // Auto incrementing ID
            'is_active' => '1', // To output the menu item or not
            'page_id' => '1', // Page ID specified from the .json file
            'target' => '', // HTML <a target="">
            'display_name' => 'Home', // Title of the menu item
            'class_name' => '', // CSS class name to be appended to the menu item
            'relative_url' => '/', // The relative URL to this page
            'submenu' => [], // Subitems, follow same structure and include another submenu => []
        ],
        2 => [ // Second menu item...

        ],
    ],
];
```

## News listing & view

1. Create a CMS page called `news` in the root of the site and select the `ArticleController` as the template.
1. Create a CMS page called `news/topic` in the root of the site and select the `ArticleController` as the template.
1. Create a CMS page called `news/topics` in the root of the site and select the `TopicController` as the template.
1. If you need news for a subsite, follow these steps again while being within that subsite.

## Profile listing & view

1. Create a CMS page for the profile listing page (ex: `profiles`) and select the `ProfileController` as the template.
1. Create a CMS page for the profile view, it must be: `profile` and select the `ProfileController` as the template.
1. You can now visit `https://domain.local/profiles` and `http://domain.local/profile/{accessid}`.

## Style guide development for a new feature

Feature names should be singular and CamelCased. To create a new feature called "Spotlight": `php artisan base:feature Spotlight`

## Adding SVG icons

1. Load the fontello-config.json file into http://fontello.com/
1. Select the new icons and download the set.
1. Load the waynestate.svg file into https://icomoon.io/app/#/select
1. Select all the icons and download the set.
1. Open the new SVG icon(s) in the editor of your choice.
1. Save each file under resources/views/svg as a blade partial.
1. Remove the comment from the svg file.
1. Apply this code to the svg tag: `class="{{ $class ?? '' }}" aria-labelledby="{{ $name ?? '' }}"`.

## Using SVG icons
1. `<svg>` replace with: `@svg('filename', 'optional classes', 'optional label')`

## Lazy loading

1. `<img>` replace with: `@image('/path/to/image.jpg', 'alt text', 'optional classes')`
1.  Background images: `<div data-src="/path/to/image.jpg"></div>`

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Licensing

Base Template is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
