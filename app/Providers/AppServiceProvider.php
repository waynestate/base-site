<?php

namespace App\Providers;

use App\Repositories\PeopleRepository;
use App\Repositories\ProfileRepository;
use Contracts\Repositories\ProfileRepositoryContract;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
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
    public function boot(): void
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

        Blade::directive('svg', function ($expression) {
            // Since all paramters are concated into a string we need to parse them out into an array
            $params = explode(',', $expression);

            // Default the label to the title
            if (empty($params[2])) {
                $params[2] = $params[0];
            }

            // We have three parameters that are optional so we need to set them as blank strings if they weren't passed in
            for ($i=0; $i <= 2; $i++) {
                if (empty($params[$i])) {
                    $params[$i] = "''";
                }
            }

            return "<?php if(view()->exists('svg.'.strtolower(trim(".$params[0].")))) { echo view('svg.'.strtolower(trim(".$params[0].")), ['name' => strtolower(trim($params[0])), 'class' => $params[1], 'label' => strtolower(trim($params[2]))])->render(); } ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if (using_styleguide()) {
            $this->prefix = 'Styleguide';
        }

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
                return in_array(basename($filename), ['RequestDataRepositoryContract.php', 'ProfileRepositoryContract.php']);
            })
            ->each(function ($filename) {
                $this->app->bind('Contracts\Repositories\\'.basename($filename, '.php'), $this->getPrefix().'\Repositories\\'.basename(str_replace('Contract', '', $filename), '.php'));
            });

        // Get the Site Information to determine if we load the ProfileRepository or PeopleRepository
        try {
            $site = json_decode(Storage::disk('public')->get('index.json'), true);
        } catch (FileNotFoundException $e) {
            $site = [];
        }
        if (!using_styleguide() && empty($site['site']['people']['site_id'])) {
            $this->app->bind(ProfileRepositoryContract::class, ProfileRepository::class);
        } elseif (using_styleguide()) {
            $this->app->bind(ProfileRepositoryContract::class, \Styleguide\Repositories\PeopleRepository::class);
        } else {
            $this->app->bind(ProfileRepositoryContract::class, PeopleRepository::class);
        }
    }

    /**
     * Get the prefix.
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }
}
