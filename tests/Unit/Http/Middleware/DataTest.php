<?php

namespace Tests\Unit\Http\Middleware;

use Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Storage;

class DataTest extends TestCase
{
    /**
     * @covers App\Http\Middleware\Data::handle
     * @test
     */
    public function data_middleware_should_run_successfully()
    {
        $request = new Request();
        $request = $request->create('styleguide');

        app('App\Http\Middleware\Data')->handle($request, function ($response) {
            // Controller check
            $this->assertTrue(is_string($response->controller));

            // Data check
            $this->assertTrue(is_array($response->data));
        });
    }

    /**
     * @covers App\Http\Middleware\Data::handle
     * @covers App\Repositories\PageRepository::getRequestData
     * @test
     */
    public function no_homepage_found_should_redirect_to_styleguide()
    {
        // Change the ENV so it runs through the real data middleware
        config(['app.env' => 'dev']);

        $request = new Request();
        $request = $request->create('/');

        Storage::shouldReceive('disk->exists')->andReturn(false);

        $redirect = app('App\Http\Middleware\Data')->handle($request, function () {
        });

        $this->assertEquals('styleguide', basename($redirect->headers->get('location')));
    }

    /**
     * @covers App\Http\Middleware\Data::handle
     * @test
     */
    public function site_methods_should_merge_with_all_methods()
    {
        $request = new Request();
        $request = $request->create('styleguide');

        config([
            'base.global.sites' => [
                2 => [
                    'callbacks' => [
                        '\Mocked\Method@mockMethod',
                    ],
                ],
            ],
        ]);

        $this->app->bind('Styleguide\Mocked\Method', function ($app) {
            $mock = Mockery::mock('Mocked\Method');
            $mock->shouldReceive('mockMethod')->andReturn(['mockMethod' => true]);

            return $mock;
        });

        app('App\Http\Middleware\Data')->handle($request, function ($request) {
            $this->assertTrue($request->data['mockMethod']);
        });
    }

    /**
     * @covers App\Http\Middleware\Data::getPrefix
     * @test
     */
    public function prefix_should_return_string()
    {
        $this->assertTrue(is_string(app('App\Http\Middleware\Data')->getPrefix()));
    }

    /**
     * @covers App\Http\Middleware\Data::getControllerNamespace
     * @test
     */
    public function controller_namespace_should_return_string()
    {
        // Test an existing app controller
        $this->assertTrue(is_string(app('App\Http\Middleware\Data')->getControllerNamespace('Controller')));

        // Test an existing styleguide controller
        $this->assertTrue(is_string(app('App\Http\Middleware\Data')->getControllerNamespace('StyleGuideController')));

        // When trying to reference a styleguide controller that doesn't exist, test that it defaults to app namespace
        $controller = ucfirst($this->faker->word).ucfirst($this->faker->word).ucfirst($this->faker->word);
        $namespace = app('App\Http\Middleware\Data')->getControllerNamespace($controller);
        $this->assertStringContainsString('App\Http\Controllers', $namespace);
    }

    /**
     * @covers App\Http\Middleware\Data::getPathFromRequest
     * @test
     */
    public function when_the_request_has_no_matched_route_the_path_should_be_path()
    {
        $actual_path = $this->faker->word;

        $request = new Request();
        $request = $request->create($actual_path);

        $path = app('App\Http\Middleware\Data')->getPathFromRequest($request);

        $this->assertEquals($path, $actual_path);
    }

    /**
     * @covers App\Http\Middleware\Data::getPathFromRequest
     * @test
     */
    public function when_the_request_has_a_matched_route_the_path_should_have_no_route_parameters()
    {
        $actual_path = config('base.news_view_route').'/slug-123';

        $request = new Request([], [], [], [], [], ['REQUEST_URI' => $actual_path]);

        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', config('base.news_view_route').'/{slug}-{id}', []))->bind($request);
        });

        $path = app('App\Http\Middleware\Data')->getPathFromRequest($request);

        $this->assertEquals($path, config('base.news_view_route'));
    }
}
