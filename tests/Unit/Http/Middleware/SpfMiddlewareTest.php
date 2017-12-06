<?php

namespace Tests\App\Http\Middleware;

use Tests\TestCase;
use Illuminate\Http\Request;

class SpfMiddlewareTest extends TestCase
{
    /**
     * @covers App\Http\Middleware\SpfMiddleware::handle
     * @test
     */
    public function layout_should_be_spf()
    {
        // Fake request
        $request = new Request([], [], [], [], [], ['REQUEST_URI' => '/styleguide']);
        $request->merge(['spf' => 'navigate']);

        // Call data middleware to get stub homepage data
        app('\App\Http\Middleware\DataMiddleware')->handle($request, function ($response) {
            // Call SPF middleware
            $response = app('\App\Http\Middleware\SpfMiddleware')->handle($response, function () {
            });

            json_decode($response->getContent());

            // Make sure there was no JSON erros
            $this->assertEquals(true, json_last_error() == JSON_ERROR_NONE);
        });
    }

    /**
     * @covers App\Http\Middleware\SpfMiddleware::handle
     * @test
     */
    public function layout_should_not_be_set()
    {
        $request = new Request([], [], [], [], [], ['REQUEST_URI' => '/styleguide']);

        // Call data middleware to get stub homepage data
        app('App\Http\Middleware\DataMiddleware')->handle($request, function ($response) {
            // Call SPF middleware
            app('App\Http\Middleware\SpfMiddleware')->handle($response, function ($request) {
                // Make sure there isn't a layout override
                $this->assertTrue(! isset($request->data['layout']));
            });
        });
    }

    /**
     * @covers App\Http\Middleware\SpfMiddleware::getRouteParameters
     * @test
     */
    public function getting_route_parameters_should_return_parameters()
    {
        // Get a random news id
        $news_id = $this->faker->numberBetween(1, 100);

        // Create a new request with a controller
        $request = new Request();
        $request->controller = 'App\Http\Controllers\NewsController';

        // Get the routes parameters
        $parameters = app('App\Http\Middleware\SpfMiddleware')->getRouteParameters($request, 'show', ['id' => $news_id]);

        // Make sure we only have 2 parameters to invoke
        $this->assertCount(2, $parameters);

        // Make sure the parameters are correct values
        $this->assertInstanceOf('Illuminate\Http\Request', $parameters['request']);
        $this->assertEquals($news_id, $parameters['id']);
    }

    /**
     * @covers App\Http\Middleware\SpfMiddleware::getReflectionMethod
     * @test
     */
    public function getting_reflect_method_should_be_correct_method()
    {
        $reflection = app('App\Http\Middleware\SpfMiddleware')->getReflectionMethod('App\Http\Controllers\NewsController', 'show');

        $this->assertInstanceOf('\ReflectionMethod', $reflection);
    }

    /**
     * @covers App\Http\Middleware\SpfMiddleware::getRouteQuery
     * @test
     */
    public function getting_route_query_should_return_route_query()
    {
        $request = new Request();

        $query = app('App\Http\Middleware\SpfMiddleware')->getRouteQuery($request);

        $this->assertEquals([], $query);
    }
}
