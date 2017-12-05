<?php

namespace Tests\App\Exceptions;

use Tests\TestCase;

class HandlerTest extends TestCase
{
    /**
     * @test
     */
    public function error_404_should_return_view_404()
    {
        // Set the debug to false so we hit the custom view files rather than seeing the exceptions
        config(['app.debug' => false]);

        $response = $this->call('GET', '/'.$this->faker->word.'/'.$this->faker->word.'/'.$this->faker->word);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertContains('<h1>404</h1>', $response->getContent());

        // Set it back
        config(['app.debug' => true]);
    }
}
