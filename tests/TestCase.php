<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Ran before every test.
     */
    public function setUp() : void
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

        // Don't run through the exception handler so we have cleaner errors in CLI
        $this->withoutExceptionHandling();

        // Create a new faker that every test can use
        $this->faker = (new Factory)->create();
    }
}
