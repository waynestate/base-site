<?php

namespace Tests\App\Http\Middleware;

use Tests\TestCase;
use Illuminate\Http\Request;

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
}
