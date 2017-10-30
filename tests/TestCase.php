<?php

namespace Tests;

use Faker\Factory;

class TestCase extends \Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * Ran before every test.
     */
    public function setUp()
    {
        parent::setUp();

        // Set these super globals since some packages rely on them
        $_SERVER['HTTP_USER_AGENT'] = '';
        $_SERVER['HTTP_HOST'] = '';
        $_SERVER['REQUEST_URI'] = '';

        // Force the top menu to be enabled for now since the tests are written specifically for this condition
        config(['app.top_menu_enabled' => true]);

        // Reset the WSU API key so we never make real connections to the API
        config(['app.wsu_api_key' => '']);

        // Create a new faker that every test can use
        $this->faker = (new Factory)->create();
    }
}
