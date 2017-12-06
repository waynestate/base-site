<?php

namespace Tests\App\Http\Middleware;

use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Http\Request;

class FormyMiddlewareTest extends TestCase
{
    /**
     * @covers App\Http\Middleware\FormyMiddleware::__construct
     * @covers App\Http\Middleware\FormyMiddleware::handle
     * @test
     */
    public function formy_embed_should_show_form_in_page_content()
    {
        // Fake request
        $request = new Request();
        $request->data = [
            'page' => [
                'content' => [
                    'main' => 'original-form-main',
                ],
            ],
        ];

        // Fake return
        $return = [
            'main' => 'replaced-form-main',
        ];

        // Mock the parser
        $parser = Mockery::mock('Waynestate\FormyParser\Parser');
        $parser->shouldReceive('parse')->once()->andReturn($return);

        // Call the middleware
        app('App\Http\Middleware\FormyMiddleware', ['parser' => $parser])->handle($request, function ($response) use ($return) {
            $this->assertEquals($return, $response->data['page']['content']['main']);
        });
    }
}
