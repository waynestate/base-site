<?php

namespace Tests\Unit\Http\Middleware;

use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Http\Request;

class FormyTest extends TestCase
{
    /**
     * @covers App\Http\Middleware\Formy::__construct
     * @covers App\Http\Middleware\Formy::handle
     * @test
     */
    public function formy_embed_should_show_form_in_page_content()
    {
        // Fake request
        $request = new Request();
        $request->data = [
            'base' => [
                'page' => [
                    'content' => [
                        'main' => 'original-form-main',
                    ],
                ],
            ]
        ];

        // Fake return
        $return = [
            'main' => 'replaced-form-main',
        ];

        // Mock the parser
        $parser = Mockery::mock('Waynestate\FormyParser\Parser');
        $parser->shouldReceive('parse')->once()->andReturn($return);

        // Call the middleware
        app('App\Http\Middleware\Formy', ['parser' => $parser])->handle($request, function ($response) use ($return) {
            $this->assertEquals($return, $response->data['base']['page']['content']['main']);
        });
    }
}
