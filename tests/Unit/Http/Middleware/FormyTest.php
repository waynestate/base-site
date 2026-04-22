<?php

namespace Tests\Unit\Http\Middleware;

use PHPUnit\Framework\Attributes\Test;
use App\Http\Middleware\Formy;
use Tests\TestCase;
use Mockery;
use Illuminate\Http\Request;
use Waynestate\FormyParser\Parser;

final class FormyTest extends TestCase
{
    #[Test]
    public function formy_embed_should_show_form_in_page_content(): void
    {
        $content = $this->faker->sentence();
        $parsed = $this->faker->sentence();

        // Fake request
        $request = new Request();
        $request->data = [
            'base' => [
                'page' => [
                    'content' => [
                        'main' => $content,
                    ],
                ],
            ],
        ];

        // Mock the parser
        $this->app->bind(Parser::class, function () use ($content, $parsed) {
            $mock = Mockery::mock(Parser::class);
            $mock->shouldReceive('parse')->with($content)->once()->andReturn($parsed);

            return $mock;
        });

        // Call the middleware
        app(Formy::class)->handle($request, function ($request) use ($parsed) {
            $this->assertEquals($parsed, $request->data['base']['page']['content']['main']);
        });
    }

    #[Test]
    public function description_fields_should_be_parsed(): void
    {
        $description = $this->faker->sentence();
        $parsedDescription = $this->faker->sentence();
        $nestedDescription = $this->faker->sentence();
        $parsedNestedDescription = $this->faker->sentence();

        // Fake request
        $request = new Request();
        $request->data = [
            'base' => [
                'description' => $description,
                'nested' => [
                    'description' => $nestedDescription,
                ],
            ],
        ];

        // Mock the parser
        $this->app->bind(Parser::class, function () use ($description, $parsedDescription, $nestedDescription, $parsedNestedDescription) {
            $mock = Mockery::mock(Parser::class);
            $mock->shouldReceive('parse')->with($description)->once()->andReturn($parsedDescription);
            $mock->shouldReceive('parse')->with($nestedDescription)->once()->andReturn($parsedNestedDescription);

            return $mock;
        });

        // Call the middleware
        app(Formy::class)->handle($request, function ($request) use ($parsedDescription, $parsedNestedDescription) {
            $this->assertEquals($parsedDescription, $request->data['base']['description']);
            $this->assertEquals($parsedNestedDescription, $request->data['base']['nested']['description']);
        });
    }
}
