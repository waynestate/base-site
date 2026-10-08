<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    /**
     * Ran before every test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Set these super globals since some packages rely on them
        $_SERVER['HTTP_USER_AGENT'] = '';
        $_SERVER['HTTP_HOST'] = '';
        $_SERVER['REQUEST_URI'] = '';

        // Force the top menu to be enabled for now since the tests are written specifically for this condition
        config(['base.top_menu_enabled' => true]);

        // Reset the WSU API key so we never make real connections to the API
        config(['base.wsu_api_key' => '']);

        // Reset the group_id config
        config(['base.profile.group_id' => null]);

        // Don't run through the exception handler so we have cleaner errors in CLI
        $this->withoutExceptionHandling();

        $this->withoutMiddleware(
            ThrottleRequests::class,
        );

        // Create a new faker that every test can use
        $this->faker = (new Factory())->create();
    }

    /**
     * Declare an empty class under the given name so class_exists() finds it.
     */
    protected function fakeClass(string $class): void
    {
        if (! class_exists($class, false)) {
            class_alias(get_class(new class () {}), $class);
        }
    }

    /**
     * Swap the base disk for an empty fake holding only what the generator commands read.
     */
    protected function fakeBaseDisk(): void
    {
        $files = collect(Storage::disk('base')->files('stubs'))
            ->push('styleguide/menu.json')
            ->mapWithKeys(fn ($path) => [$path => Storage::disk('base')->get($path)]);

        // A temp dir is case-sensitive on Linux like CI, where a macOS bind mount is not
        $root = sys_get_temp_dir().'/base-disk';
        (new Filesystem())->deleteDirectory($root);
        Storage::set('base', Storage::build(['driver' => 'local', 'root' => $root]));

        $files->each(fn ($contents, $path) => Storage::disk('base')->put($path, $contents));
    }
}
