<?php

namespace Tests\Unit\Providers;

use PHPUnit\Framework\Attributes\Test;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

final class AppServiceProviderTest extends TestCase
{
    #[Test]
    public function site_repository_should_overload_base_repository(): void
    {
        config(['base.site_namespace' => 'Nursing']);
        $this->fakeClass('App\Repositories\OverloadFixtureRepository');
        $this->fakeClass('App\Nursing\Repositories\OverloadFixtureRepository');

        $this->assertSame(
            'App\Nursing\Repositories\OverloadFixtureRepository',
            (new AppServiceProvider($this->app))->getRepository('OverloadFixtureRepository')
        );
    }

    #[Test]
    public function base_repository_without_site_overload_should_be_used(): void
    {
        config(['base.site_namespace' => 'Nursing']);
        $this->fakeClass('App\Repositories\BaseOnlyFixtureRepository');

        $this->assertSame(
            'App\Repositories\BaseOnlyFixtureRepository',
            (new AppServiceProvider($this->app))->getRepository('BaseOnlyFixtureRepository')
        );
    }

    #[Test]
    public function styleguide_site_repository_should_overload_in_styleguide(): void
    {
        config(['base.site_namespace' => 'Nursing']);
        $this->fakeClass('App\Repositories\PromoFixtureRepository');
        $this->fakeClass('Styleguide\Repositories\PromoFixtureRepository');
        $this->fakeClass('App\Nursing\Styleguide\Repositories\PromoFixtureRepository');

        $provider = new AppServiceProvider($this->app);
        $prefix = new \ReflectionProperty($provider, 'prefix');
        $prefix->setValue($provider, 'Styleguide');

        $this->assertSame(
            'App\Nursing\Styleguide\Repositories\PromoFixtureRepository',
            $provider->getRepository('PromoFixtureRepository')
        );
    }

    #[Test]
    public function site_service_provider_should_be_auto_registered_when_exists(): void
    {
        config(['base.site_namespace' => 'Nursing']);

        $providerClass = 'App\Nursing\NursingServiceProvider';
        if (! class_exists($providerClass, false)) {
            eval('
                namespace App\Nursing;
                use Illuminate\Support\ServiceProvider;
                class NursingServiceProvider extends ServiceProvider {
                    public static bool $registered = false;
                    public function register(): void {
                        self::$registered = true;
                    }
                }
            ');
        }

        (new AppServiceProvider($this->app))->register();

        $this->assertTrue(\App\Nursing\NursingServiceProvider::$registered);
    }

    #[Test]
    public function site_controllers_should_be_bound_in_container_when_they_exist(): void
    {
        config(['base.site_namespace' => 'Nursing']);
        $this->fakeClass('App\Nursing\Controllers\PromoController');

        (new AppServiceProvider($this->app))->boot();

        $this->assertInstanceOf(
            'App\Nursing\Controllers\PromoController',
            app(\App\Http\Controllers\PromoController::class)
        );
    }

    #[Test]
    public function site_view_path_should_be_prepended_when_directory_exists(): void
    {
        config(['base.site_namespace' => 'Nursing']);
        $fixtureViewDir = resource_path('views/nursing');

        if (! file_exists($fixtureViewDir)) {
            mkdir($fixtureViewDir, 0777, true);
        }

        try {
            (new AppServiceProvider($this->app))->boot();
            $paths = View::getFinder()->getPaths();
            $this->assertSame($fixtureViewDir, $paths[0]);
        } finally {
            if (file_exists($fixtureViewDir)) {
                rmdir($fixtureViewDir);
            }
        }
    }
}
