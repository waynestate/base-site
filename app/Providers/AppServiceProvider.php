<?php

namespace App\Providers;

use Waynestate\Api\Connector;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;

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
        Blade::directive('image', function ($expression) {
            // Since all paramters are concated into a string we need to parse them out into an array
            $params = explode(',', $expression);

            // We have three parameters that are optional so we need to set them as blank strings if they weren't passed in
            for ($i=0; $i <= 2; $i++) {
                if (empty($params[$i])) {
                    $params[$i] = "''";
                }
            }

            return "<?php echo view('components.image-lazy', ['src' => $params[0], 'alt' => $params[1], 'class' => $params[2]])->render(); ?>";
        });
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
        collect(Storage::disk('base')->allFiles('contracts'))
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
