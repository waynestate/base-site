<?php

namespace Tests\App\Http\Middleware;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Storage;

class DataMiddlewareTest extends TestCase
{
    /**
     * @covers App\Http\Middleware\DataMiddleware::handle
     * @test
     */
    public function data_middleware_should_run_successfully()
    {
        $request = new Request();
        $request = $request->create('styleguide');

        app('App\Http\Middleware\DataMiddleware')->handle($request, function ($response) {
            // Controller check
            $this->assertTrue(is_string($response->controller));

            // Data check
            $this->assertTrue(is_array($response->data));
        });
    }

    /**
     * @covers App\Http\Middleware\DataMiddleware::handle
     * @covers App\Repositories\PageRepository::getRequestData
     * @test
     */
    public function no_homepage_found_should_redirect_to_styleguide()
    {
        // Change the ENV so it runs through the real DataMiddleware
        config(['app.env' => 'dev']);

        $request = new Request();
        $request = $request->create('/');

        Storage::shouldReceive('disk->exists')->andReturn(false);

        $redirect = app('App\Http\Middleware\DataMiddleware')->handle($request, function () {
        });

        $this->assertEquals('styleguide', basename($redirect->headers->get('location')));
    }

    /**
     * @covers App\Http\Middleware\DataMiddleware::getPrefix
     * @test
     */
    public function prefix_should_return_string()
    {
        $this->assertTrue(is_string(app('App\Http\Middleware\DataMiddleware')->getPrefix()));
    }

    /**
     * @covers App\Http\Middleware\DataMiddleware::getControllerNamespace
     * @test
     */
    public function controller_namespace_should_return_string()
    {
        // Test an existing app controller
        $this->assertTrue(is_string(app('App\Http\Middleware\DataMiddleware')->getControllerNamespace('Controller')));

        // Test an existing styleguide controller
        $this->assertTrue(is_string(app('App\Http\Middleware\DataMiddleware')->getControllerNamespace('StyleGuideController')));

        // When trying to reference a styleguide controller that doesn't exist, test that it defaults to app namespace
        $controller = ucfirst($this->faker->word).ucfirst($this->faker->word).ucfirst($this->faker->word);
        $namespace = app('App\Http\Middleware\DataMiddleware')->getControllerNamespace($controller);
        $this->assertContains('App\Http\Controllers', $namespace);
    }

    /**
     * @covers App\Http\Middleware\DataMiddleware::getPathFromRequest
     * @test
     */
    public function when_the_request_has_no_matched_route_the_path_should_be_path()
    {
        $actual_path = $this->faker->word;

        $request = new Request();
        $request = $request->create($actual_path);

        $path = app('App\Http\Middleware\DataMiddleware')->getPathFromRequest($request);

        $this->assertEquals($path, $actual_path);
    }

    /**
     * @covers App\Http\Middleware\DataMiddleware::getPathFromRequest
     * @test
     */
    public function when_the_request_has_a_matched_route_the_path_should_have_no_route_parameters()
    {
        $actual_path = 'news/slug-123';

        $request = new Request([], [], [], [], [], ['REQUEST_URI' => $actual_path]);

        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', 'news/{slug}-{id}', []))->bind($request);
        });

        $path = app('App\Http\Middleware\DataMiddleware')->getPathFromRequest($request);

        $this->assertEquals($path, 'news');
    }
}
