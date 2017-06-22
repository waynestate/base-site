<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Load The Application Configs
|--------------------------------------------------------------------------
|
| Specify which /config/ files should be loaded and available via the
| global config() function.
|
*/

$app->configure('app');
$app->configure('cache');
$app->configure('database');
$app->configure('newrelic');
$app->configure('view');

/*
|--------------------------------------------------------------------------
| Enable Sessions
|--------------------------------------------------------------------------
|
| If the application requires sessions start it.
|
*/

if (config('app.sessions_enable') == true) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Styleguide
|--------------------------------------------------------------------------
|
| Forward the user to the styleguide if the site hasn't been started.
|
*/
$styleguide = false;

// Enable the styleguide if we are testing or under the styleguide folder
if (config('app.env') == 'testing' || (isset($_SERVER['REQUEST_URI']) && substr($_SERVER['REQUEST_URI'], 0, 11) == '/styleguide')) {
    $styleguide = true;
}

// Forward them to the styleguide if they are not on the homepage and the site hasn't been built yet
if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] == '/' && ! is_file(storage_path().'/app/public/index.json')) {
    header('Location: /styleguide');
    die();
}

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Cache\Repository::class,
    Illuminate\Contracts\Cache\Repository::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware([
    App\Http\Middleware\TrustedProxyMiddleware::class,
    App\Http\Middleware\NewRelicMiddleware::class,
]);

$app->routeMiddleware([
    'data' => App\Http\Middleware\DataMiddleware::class,
    'formy' => App\Http\Middleware\FormyMiddleware::class,
    'spf' => App\Http\Middleware\SpfMiddleware::class,
]);

// If we are viewing the styleguide swap the DataMiddleware with the one from the
// styleguide to enable pulling fake pages and data.
if ($styleguide == true) {
    $app->routeMiddleware([
        'data' => Styleguide\Http\Middleware\DataMiddleware::class,
    ]);
}

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// Determine which Provider we will use to ensure we depedency inject the proper repositories
if ($styleguide == true) {
    $app->register(Styleguide\Providers\AppServiceProvider::class);
} else {
    $app->register(App\Providers\AppServiceProvider::class);
}
$app->register(Illuminate\Redis\RedisServiceProvider::class);

// Display Debugbar
if (config('app.debug') === true) {
    $app->configure('debugbar');
    $app->register(Barryvdh\Debugbar\LumenServiceProvider::class);
}

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__.'/../app/Http/routes.php';
});

return $app;
