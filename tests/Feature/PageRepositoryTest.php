<?php

namespace Tests\Styleguide\Repositories;

use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Support\Facades\Storage;

class PageRepositoryTest extends TestCase
{
    /**
     * @covers App\Http\Controllers\HomepageController
     * @covers App\Http\Controllers\ChildpageController
     * @covers App\Http\Controllers\ProfileController
     * @covers App\Http\Controllers\NewsController
     * @covers App\Http\Controllers\DirectoryController
     * @covers Styleguide\Repositories\PageRepository::getRequestData
     * @test
     */
    public function all_styleguide_routes_should_load_successfully()
    {
        $this->getPageResponses()
            ->each(function ($page) {
                $this->assertTrue(is_string($page['path']), 'ERROR: Path to styleguide page not found. Make sure it exists in the styleguide menu. Optionally you can added public $path = \'/styleguide/path/to/page\' in your styleguide Page class.');

                $this->assertEquals(200, $page['response']->status(), 'Styleguide error at path: '.$page['path']);
            });
    }

    /**
     * @test
     */
    public function all_styleguide_routes_with_no_data_should_load_successfully()
    {
        // Overload all styleguide repositories to only return a blank array
        collect(Storage::disk('base')->allFiles('factories'))
            ->reject(function ($filename) {
                return in_array(basename($filename), ['Page.php']);
            })
            ->each(function ($filename) {
                $class = 'Factories\\'.basename($filename, '.php');

                $this->app->bind($class, function ($app) use ($class) {
                    $factory = Mockery::mock($class)->makePartial();
                    $factory->shouldReceive('create')->andReturn([]);

                    return $factory;
                });
            });

        $this->getPageResponses()
            ->each(function ($page) {
                $this->assertTrue(($page['response']->status() !== 500), '500 error in styleguide at path: '.$page['path'] . '. This is likely due to not accounting for a blank array coming back from the factory in your view.');
            });
    }

    /**
     * Get all styleguide page responses.
     *
     * @return Illuminate\Support\Collection
     */
    public function getPageResponses()
    {
        return collect(Storage::disk('base')->allFiles('styleguide/Pages'))
            ->reject(function ($filename) {
                return in_array(basename($filename), ['Page.php']);
            })
            ->map(function ($filename) {
                $path = app('Styleguide\Pages\\'.basename($filename, '.php'))->getPath();

                return [
                    'path' => $path,
                    'response' => $this->call('GET', $path),
                ];
            });
    }
}
