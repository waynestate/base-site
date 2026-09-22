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
        $content = "[\'formy-shortcode\']";
        $strippedContent = "['formy-shortcode']";
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
        $this->app->bind(Parser::class, function () use ($strippedContent, $parsed) {
            $mock = Mockery::mock(Parser::class);
            $mock->shouldReceive('parse')->with($strippedContent)->once()->andReturn($parsed);

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
        $description = "[\'description\']";
        $strippedDescription = "['description']";
        $parsedDescription = $this->faker->sentence();
        $nestedDescription = "[\'nested\']";
        $strippedNestedDescription = "['nested']";
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
        $this->app->bind(Parser::class, function () use ($strippedDescription, $parsedDescription, $strippedNestedDescription, $parsedNestedDescription) {
            $mock = Mockery::mock(Parser::class);
            $mock->shouldReceive('parse')->with($strippedDescription)->once()->andReturn($parsedDescription);
            $mock->shouldReceive('parse')->with($strippedNestedDescription)->once()->andReturn($parsedNestedDescription);

            return $mock;
        });

        // Call the middleware
        app(Formy::class)->handle($request, function ($request) use ($parsedDescription, $parsedNestedDescription) {
            $this->assertEquals($parsedDescription, $request->data['base']['description']);
            $this->assertEquals($parsedNestedDescription, $request->data['base']['nested']['description']);
        });
    }

    #[Test]
    public function it_should_not_parse_if_no_shortcode_is_present_but_still_strip_slashes(): void
    {
        $content = "No shortcode here, but has \'slashes\'";
        $expectedContent = "No shortcode here, but has 'slashes'";
        $description = "Another one without shortcode, but has \'slashes\'";
        $expectedDescription = "Another one without shortcode, but has 'slashes'";

        // Fake request
        $request = new Request();
        $request->data = [
            'base' => [
                'page' => [
                    'content' => [
                        'main' => $content,
                    ],
                ],
                'description' => $description,
            ],
        ];

        // Mock the parser - should NOT receive any calls
        $this->app->bind(Parser::class, function () {
            $mock = Mockery::mock(Parser::class);
            $mock->shouldNotReceive('parse');

            return $mock;
        });

        // Call the middleware
        app(Formy::class)->handle($request, function ($request) use ($expectedContent, $expectedDescription) {
            $this->assertEquals($expectedContent, $request->data['base']['page']['content']['main']);
            $this->assertEquals($expectedDescription, $request->data['base']['description']);
        });
    }

    #[Test]
    public function excerpt_fields_should_be_parsed(): void
    {
        $excerpt = "[\'excerpt-shortcode\']";
        $strippedExcerpt = "['excerpt-shortcode']";
        $parsedExcerpt = $this->faker->sentence();
        $nestedExcerpt = "[\'nested-excerpt\']";
        $strippedNestedExcerpt = "['nested-excerpt']";
        $parsedNestedExcerpt = $this->faker->sentence();

        // Fake request
        $request = new Request();
        $request->data = [
            'base' => [
                'excerpt' => $excerpt,
                'components' => [
                    'modular-accordion-1' => [
                        'data' => [
                            [
                                'excerpt' => $nestedExcerpt,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // Mock the parser
        $this->app->bind(Parser::class, function () use ($strippedExcerpt, $parsedExcerpt, $strippedNestedExcerpt, $parsedNestedExcerpt) {
            $mock = Mockery::mock(Parser::class);
            $mock->shouldReceive('parse')->with($strippedExcerpt)->once()->andReturn($parsedExcerpt);
            $mock->shouldReceive('parse')->with($strippedNestedExcerpt)->once()->andReturn($parsedNestedExcerpt);

            return $mock;
        });

        // Call the middleware
        app(Formy::class)->handle($request, function ($request) use ($parsedExcerpt, $parsedNestedExcerpt) {
            $this->assertEquals($parsedExcerpt, $request->data['base']['excerpt']);
            $this->assertEquals($parsedNestedExcerpt, $request->data['base']['components']['modular-accordion-1']['data'][0]['excerpt']);
        });
    }

    #[Test]
    public function ignored_structural_keys_should_not_be_parsed(): void
    {
        // Fake request with description fields inside ignored structural keys
        $request = new Request();
        $request->data = [
            'base' => [
                'server' => [
                    'description' => "[\'server-desc\']",
                ],
                'site_menu' => [
                    'description' => "[\'menu-desc\']",
                ],
                'top_menu' => [
                    'description' => "[\'top-menu-desc\']",
                ],
                'breadcrumbs' => [
                    'description' => "[\'breadcrumb-desc\']",
                ],
            ],
        ];

        // Mock the parser - should NOT receive any calls
        $this->app->bind(Parser::class, function () {
            $mock = Mockery::mock(Parser::class);
            $mock->shouldNotReceive('parse');

            return $mock;
        });

        // Call the middleware
        app(Formy::class)->handle($request, function ($request) {
            $this->assertEquals("[\'server-desc\']", $request->data['base']['server']['description']);
            $this->assertEquals("[\'menu-desc\']", $request->data['base']['site_menu']['description']);
            $this->assertEquals("[\'top-menu-desc\']", $request->data['base']['top_menu']['description']);
            $this->assertEquals("[\'breadcrumb-desc\']", $request->data['base']['breadcrumbs']['description']);
        });
    }
}
