<?php

namespace Tests\App\Http\Middleware;

use Tests\TestCase;
use Mockery as Mockery;
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
        // Fake the parameters for a controllers method
        $reflection = ['request', 'id'];

        // Fake the parameter values
        $request = new Request();
        $id = $this->faker->randomDigit;

        // Mock the middleware
        $spf = Mockery::mock('App\Http\Middleware\SpfMiddleware')->makePartial();

        // Return a fake controller
        $spf->shouldReceive('getReflectionMethod')->once()->andReturn('FakeController');

        // Return the fake parameters
        $spf->shouldReceive('getReflectionParameters')->once()->andReturn($reflection);

        // Get the route parameter values
        $parameters =  $spf->getRouteParameters($request, 'show', ['id' => $id]);

        // Make sure the parameters are correct values
        $this->assertCount(2, $parameters);
        $this->assertInstanceOf('Illuminate\Http\Request', $parameters['request']);
        $this->assertEquals($id, $parameters['id']);
    }

    /**
     * @covers App\Http\Middleware\SpfMiddleware::getReflectionParameters
     * @test
     */
    public function getting_reflection_parameters_should_return_array()
    {
        $reflection = new \ReflectionMethod('App\Http\Controllers\ChildpageController', 'index');
        $spf = app('App\Http\Middleware\SpfMiddleware');
        $parameters = $spf->getReflectionParameters($reflection);

        $this->assertTrue(in_array('request', $parameters));
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
