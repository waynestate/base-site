<?php

namespace Tests\Feature;

use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SiteControllerRoutesTest extends TestCase
{
    #[Test]
    public function news_routes_should_use_the_site_controller_override(): void
    {
        $this->fakeClass('App\Http\Controllers\RouteFakeController');
        $this->fakeClass('App\Http\Controllers\Custom\RouteFakeController');
        config(['base.news_controller' => 'App\Http\Controllers\RouteFakeController']);

        Route::setRoutes(new RouteCollection());
        require base_path('routes/web.php');

        $actions = collect(Route::getRoutes()->getRoutes())->map->getActionName();

        $this->assertContains('App\Http\Controllers\Custom\RouteFakeController@index', $actions);
        $this->assertContains('App\Http\Controllers\Custom\RouteFakeController@show', $actions);
    }
}
