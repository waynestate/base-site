<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Waynestate\Api\Connector;

class AppServiceProvider extends ServiceProvider
{
    /** @var $prefx **/
    protected $prefix = 'App';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (using_styleguide()) {
            $this->prefix = 'Styleguide';
        }

        // WSU API
        $this->app->bind('Waynestate\Api\Connector', function () {
            $api = new Connector(
                config('app.wsu_api_key')
            );

            // Set the Cache Directory for the WSU API
            $api->cache_dir = storage_path().'/app/api/';

            return $api;
        });

        // Bind all repositories following the filename convention
        collect(glob(__DIR__.'/../../contracts/Repositories/*.php'))
            ->reject(function ($filename) {
                return in_array(basename($filename), ['DataRepositoryContract.php']);
            })
            ->each(function ($filename) {
                $this->app->bind('Contracts\Repositories\\'.basename($filename, '.php'), $this->getPrefix().'\Repositories\\'.basename(str_replace('Contract', '', $filename), '.php'));
            });
    }

    /**
     * Get the prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
}
