<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PageRepositoryTest extends TestCase
{
    #[Test]
    public function all_styleguide_routes_should_load_successfully(): void
    {
        $this->getPageResponses(false)
            ->each(function ($page) {
                $this->assertTrue(is_string($page['path']), 'ERROR: Path to styleguide page not found. Make sure it exists in the styleguide menu. Optionally you can added public $path = \'/styleguide/path/to/page\' in your styleguide Page class.');

                $this->assertEquals(200, $page['response']->status(), 'Styleguide error at path: '.$page['path']);
            });
    }

    #[Test]
    public function all_styleguide_routes_with_no_data_should_load_successfully(): void
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

        $this->getPageResponses(true)
            ->each(function ($page) {
                $this->assertTrue(($page['response']->status() !== 500), $page['response']->content()."\n".'500 error in styleguide at path: '.$page['path'] . '. View the error output above to solve the issue.');
            });
    }

    /**
     * Get all styleguide page responses. Since exception handling is turned off in setUp we
     * will check for 404s and disregard them when we're overloading all factories with
     * blank arrays.
     *
     * @param $handle_exceptions bool;
     */
    public function getPageResponses($handle_exceptions = false): Collection
    {
        return collect(Storage::disk('base')->allFiles('styleguide/Pages'))
            ->reject(function ($filename) {
                return in_array(basename($filename), ['Page.php']);
            })
            ->map(function ($filename) use ($handle_exceptions) {
                $path = app('Styleguide\Pages\\'.basename($filename, '.php'))->getPath();

                try {
                    $response = $this->call('GET', $path);
                } catch (NotFoundHttpException $e) {
                    if ($handle_exceptions === true) {
                        // When overloading all factories with blank arrays sometimes we expect a 404 and should not error because of it
                        $response = null;
                    } else {
                        // Custom message explaning why a 404 might be occuring
                        $this->assertEquals(200, $e->getStatusCode(), 'Styleguide page '.$filename.' is resulting in a 404. 1) Make sure the MenuRepository has a unique key so nothing is overriding the menu item. 2) If the page does not exist in the menu make sure a $path is defined within '.$filename.', refer to Pages/Profile.php for an example.');
                    }
                }

                // Reset the group_id config
                config(['profile.group_id' => null]);

                return [
                    'path' => $path,
                    'response' => $response,
                ];
            })->reject(function ($item) {
                return empty($item['response']);
            });
    }
}
