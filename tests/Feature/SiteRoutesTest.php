<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use App\Providers\AppServiceProvider;
use Tests\TestCase;

final class SiteRoutesTest extends TestCase
{
    #[Test]
    public function news_controller_should_resolve_to_site_controller(): void
    {
        config(['base.site_namespace' => 'Nursing']);
        $this->fakeClass('App\Nursing\Controllers\ArticleController');

        (new AppServiceProvider($this->app))->boot();

        $this->assertInstanceOf(
            'App\Nursing\Controllers\ArticleController',
            app(\App\Http\Controllers\ArticleController::class)
        );
    }

    #[Test]
    public function promo_controller_should_resolve_to_site_controller(): void
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
    public function profile_controller_should_resolve_to_site_controller(): void
    {
        config(['base.site_namespace' => 'Nursing']);
        $this->fakeClass('App\Nursing\Controllers\ProfileController');

        (new AppServiceProvider($this->app))->boot();

        $this->assertInstanceOf(
            'App\Nursing\Controllers\ProfileController',
            app(\App\Http\Controllers\ProfileController::class)
        );
    }
}
