<?php

namespace Tests\Unit\Http\Middleware;

use PHPUnit\Framework\Attributes\Test;
use App\Http\Middleware\Data;
use Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Storage;

final class DataTest extends TestCase
{
    #[Test]
    public function data_middleware_should_run_successfully(): void
    {
        $request = new Request();
        $request = $request->create('styleguide');

        app(Data::class)->handle($request, function ($response) {
            // Controller check
            $this->assertTrue(is_string($response->controller));

            // Data check
            $this->assertTrue(is_array($response->data));
        });
    }

    #[Test]
    public function no_homepage_found_should_redirect_to_styleguide(): void
    {
        // Change the ENV so it runs through the real data middleware
        config(['app.env' => 'dev']);

        $request = new Request();
        $request = $request->create('/');

        Storage::shouldReceive('disk->exists')->andReturn(false);

        $redirect = app(Data::class)->handle($request, function () {
        });

        $this->assertEquals('styleguide', basename($redirect->headers->get('location')));
    }

    #[Test]
    public function site_methods_should_merge_with_all_methods(): void
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

        app(Data::class)->handle($request, function ($request) {
            $this->assertTrue($request->data['base']['mockMethod']);
        });
    }

    #[Test]
    public function prefix_should_return_string(): void
    {
        $this->assertTrue(is_string(app(Data::class)->getPrefix()));
    }

    #[Test]
    public function controller_namespace_should_return_string(): void
    {
        // Test an existing app controller
        $this->assertTrue(is_string(app(Data::class)->getControllerNamespace('Controller')));

        // Test an existing styleguide controller
        $this->assertTrue(is_string(app(Data::class)->getControllerNamespace('StyleGuideController')));

        // When trying to reference a styleguide controller that doesn't exist, test that it defaults to app namespace
        $controller = ucfirst($this->faker->word()).ucfirst($this->faker->word()).ucfirst($this->faker->word());
        $namespace = app(Data::class)->getControllerNamespace($controller);
        $this->assertStringContainsString('App\Http\Controllers', $namespace);
    }

    #[Test]
    public function when_the_request_has_no_matched_route_the_path_should_be_path(): void
    {
        $actual_path = $this->faker->word();

        $request = new Request();
        $request = $request->create($actual_path);

        $path = app(Data::class)->getPathFromRequest($request);

        $this->assertEquals($path, $actual_path);
    }

    #[Test]
    public function when_the_request_has_a_matched_route_the_path_should_have_no_route_parameters(): void
    {
        $actual_path = config('base.news_view_route').'/slug-123';

        $request = new Request([], [], [], [], [], ['REQUEST_URI' => $actual_path]);

        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', config('base.news_view_route').'/{slug}-{id}', []))->bind($request);
        });

        $path = app(Data::class)->getPathFromRequest($request);

        $this->assertEquals($path, config('base.news_view_route'));
    }

    #[Test]
    public function meta_image_overrides_should_work(): void
    {
        $request = new Request();
        $request = $request->create('styleguide');

        // 1. Page-level meta image provided
        $this->app->bind('Styleguide\Repositories\PageRepository', function ($app) {
            $mock = Mockery::mock('Styleguide\Repositories\PageRepository');
            $mock->shouldReceive('getRequestData')->andReturn([
                'site' => [
                    'id' => 123,
                    'parent' => ['id' => null],
                    'title' => 'Site Title',
                    'subsite-folder' => null,
                ],
                'menu' => ['id' => 1],
                'data' => [
                    'meta_image' => 'page-image.png',
                    'meta_image_alt' => 'Page image alt',
                ],
                'page' => [
                    'id' => 1,
                    'description' => 'page description',
                    'title' => 'page title',
                    'controller' => 'HomepageController',
                ],
            ]);

            return $mock;
        });

        app(Data::class)->handle($request, function ($request) {
            $this->assertEquals('page-image.png', $request->data['base']['meta']['image']);
            $this->assertEquals('Page image alt', $request->data['base']['meta']['image_alt']);
        });

        // 2. Page-level empty, Site-level config provided
        config(['base.global.sites.123.meta_image' => 'site-image.png']);
        config(['base.global.sites.123.meta_image_alt' => 'Site image alt']);

        $this->app->bind('Styleguide\Repositories\PageRepository', function ($app) {
            $mock = Mockery::mock('Styleguide\Repositories\PageRepository');
            $mock->shouldReceive('getRequestData')->andReturn([
                'site' => [
                    'id' => 123,
                    'parent' => ['id' => null],
                    'title' => 'Site Title',
                    'subsite-folder' => null,
                ],
                'menu' => ['id' => 1],
                'data' => [
                    'meta_image' => '',
                    'meta_image_alt' => '',
                ],
                'page' => [
                    'id' => 1,
                    'description' => 'page description',
                    'title' => 'page title',
                    'controller' => 'HomepageController',
                ],
            ]);

            return $mock;
        });

        app(Data::class)->handle($request, function ($request) {
            $this->assertEquals('site-image.png', $request->data['base']['meta']['image']);
            $this->assertEquals('Site image alt', $request->data['base']['meta']['image_alt']);
        });

        // 3. Both empty (fallback to empty string in middleware, then global config in view)
        config(['base.global.sites.123.meta_image' => null]);
        config(['base.global.sites.123.meta_image_alt' => null]);

        app(Data::class)->handle($request, function ($request) {
            $this->assertEquals('', $request->data['base']['meta']['image']);
            $this->assertEquals('', $request->data['base']['meta']['image_alt']);
        });
    }

    #[Test]
    public function page_field_overrides_should_work(): void
    {
        $request = new Request();
        $request = $request->create('styleguide');

        $this->app->bind('Styleguide\Repositories\PageRepository', function ($app) {
            $mock = Mockery::mock('Styleguide\Repositories\PageRepository');
            $mock->shouldReceive('getRequestData')->andReturn([
                'site' => [
                    'id' => 123,
                    'parent' => ['id' => null],
                    'title' => 'Site Title',
                    'subsite-folder' => null,
                ],
                'menu' => ['id' => 1],
                'data' => [
                    'page_description' => 'Custom Description',
                    'page_title' => 'Custom Title',
                ],
                'page' => [
                    'id' => 1,
                    'description' => 'Original Description',
                    'title' => 'Original Title',
                    'controller' => 'HomepageController',
                ],
            ]);

            return $mock;
        });

        app(Data::class)->handle($request, function ($request) {
            $this->assertEquals('Custom Description', $request->data['base']['page']['description']);
            $this->assertEquals('Custom Title', $request->data['base']['page']['title']);
        });
    }
}
