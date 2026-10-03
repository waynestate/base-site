<?php

namespace App\Providers;

use App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use URL;
use Waynestate\Api\Connector;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    protected string $prefix = 'App';

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Allow http when on www-dev
        if (App::environment('dev')) {
            URL::forceScheme('http');
        }

        // Prepend site-specific view path if it exists
        $siteNamespace = config('base.site_namespace', 'Site');
        $siteViewPath = resource_path('views/'.Str::snake($siteNamespace));

        if (is_dir($siteViewPath)) {
            View::prependLocation($siteViewPath);
        }

        // Bind route controllers to site namespace overrides when present
        $siteControllers = [
            \App\Http\Controllers\PromoController::class,
            \App\Http\Controllers\ProfileController::class,
            \App\Http\Controllers\ArticleController::class,
        ];

        foreach ($siteControllers as $controller) {
            $siteClass = 'App\\'.$siteNamespace.'\Controllers\\'.class_basename($controller);
            if (class_exists($siteClass)) {
                $this->app->bind($controller, $siteClass);
            }
        }

        Blade::directive('image', function ($expression) {
            // Since all paramters are concated into a string we need to parse them out into an array
            $params = explode(',', $expression);

            // We have three parameters that are optional so we need to set them as blank strings if they weren't passed in
            for ($i = 0; $i <= 2; $i++) {
                if (empty($params[$i])) {
                    $params[$i] = "''";
                }
            }

            return "<?php echo view('components.image-lazy', ['src' => $params[0], 'alt' => $params[1], 'class' => $params[2]])->render(); ?>";
        });

        Blade::directive('svg', function ($expression) {
            // Since all paramters are concated into a string we need to parse them out into an array
            $params = explode(',', $expression);

            // Default the label to the title
            if (empty($params[2])) {
                $params[2] = $params[0];
            }

            // We have three parameters that are optional so we need to set them as blank strings if they weren't passed in
            for ($i = 0; $i <= 2; $i++) {
                if (empty($params[$i])) {
                    $params[$i] = "''";
                }
            }

            return "<?php if(view()->exists('svg.'.strtolower(trim(".$params[0].")))) { echo view('svg.'.strtolower(trim(".$params[0].")), ['name' => strtolower(trim($params[0])), 'class' => $params[1], 'label' => strtolower(trim($params[2]))])->render(); } ?>";
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (using_styleguide()) {
            $this->prefix = 'Styleguide';
        }

        $this->registerSiteServiceProvider();

        // WSU API
        $this->app->bind('Waynestate\Api\Connector', function () {
            $api = new Connector(
                config('base.wsu_api_key')
            );

            return $api;
        });

        // Bind all repositories following the filename convention
        collect(Storage::disk('base')->allFiles('contracts'))
            ->reject(function ($filename) {
                return in_array(basename($filename), ['RequestDataRepositoryContract.php']);
            })
            ->each(function ($filename) {
                $this->app->bind('Contracts\Repositories\\'.basename($filename, '.php'), $this->getRepository(basename(str_replace('Contract', '', $filename), '.php')));
            });
    }

    /**
     * Auto-register site-specific service provider if it exists.
     */
    protected function registerSiteServiceProvider(): void
    {
        $siteNamespace = config('base.site_namespace', 'Site');

        $providers = [
            "App\\{$siteNamespace}\\{$siteNamespace}ServiceProvider",
            "App\\{$siteNamespace}\\SiteServiceProvider",
        ];

        foreach ($providers as $provider) {
            if (class_exists($provider)) {
                $this->app->register($provider);
                break;
            }
        }
    }

    /**
     * Get the repository class, preferring its site overload under the site namespace.
     */
    public function getRepository(string $repository): string
    {
        $siteNamespace = config('base.site_namespace', 'Site');

        if ($this->getPrefix() !== 'App') {
            $siteStyleguide = 'App\\'.$siteNamespace.'\Styleguide\Repositories\\'.$repository;
            if (class_exists($siteStyleguide)) {
                return $siteStyleguide;
            }
        }

        $site = 'App\\'.$siteNamespace.'\Repositories\\'.$repository;
        if (class_exists($site)) {
            return $site;
        }

        return $this->getPrefix().'\Repositories\\'.$repository;
    }

    /**
     * Get the prefix.
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }
}
