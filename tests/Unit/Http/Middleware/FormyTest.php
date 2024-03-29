<?php

namespace Tests\Unit\Http\Middleware;

use PHPUnit\Framework\Attributes\Test;
use App\Http\Middleware\Formy;
use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Http\Request;
use Waynestate\FormyParser\Parser;

final class FormyTest extends TestCase
{
    #[Test]
    public function formy_embed_should_show_form_in_page_content(): void
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
            ],
        ];

        // Fake return
        $return = [
            'main' => 'replaced-form-main',
        ];

        // Mock the parser
        $parser = Mockery::mock(Parser::class);
        $parser->shouldReceive('parse')->once()->andReturn($return);

        // Call the middleware
        app(Formy::class, ['parser' => $parser])->handle($request, function ($response) use ($return) {
            $this->assertEquals($return, $response->data['base']['page']['content']['main']);
        });
    }
}
