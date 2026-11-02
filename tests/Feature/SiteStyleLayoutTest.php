<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SiteStyleLayoutTest extends TestCase
{
    #[Test]
    public function layout_renders_additive_site_css_and_site_js_when_provided(): void
    {
        $view = $this->view('childpage', [
            'base' => [
                'site_css' => '_resources/css/404.css',
                'site_js' => '_resources/js/main.js',
                'page' => [
                    'controller' => 'ChildpageController',
                    'title' => 'Test Page',
                    'content' => ['main' => '<p>Hello</p>'],
                ],
                'layout' => 'main',
                'show_header' => false,
                'show_site_menu' => false,
            ],
        ]);

        $html = (string) $view;

        $this->assertStringContainsString('<link rel="stylesheet" href="/_resources/css/main.css">', $html);
        $this->assertStringContainsString('<link rel="stylesheet" href="/_resources/css/404.css">', $html);
        $this->assertStringContainsString('<script src="/_resources/js/main.js"></script>', $html);

        // Verify ordering: site_css must come after main.css
        $mainCssPos = strpos($html, '<link rel="stylesheet" href="/_resources/css/main.css">');
        $siteCssPos = strpos($html, '<link rel="stylesheet" href="/_resources/css/404.css">');
        $this->assertGreaterThan($mainCssPos, $siteCssPos);
    }

    #[Test]
    public function layout_does_not_render_site_css_or_site_js_when_empty(): void
    {
        $view = $this->view('childpage', [
            'base' => [
                'page' => [
                    'controller' => 'ChildpageController',
                    'title' => 'Test Page',
                    'content' => ['main' => '<p>Hello</p>'],
                ],
                'layout' => 'main',
                'show_header' => false,
                'show_site_menu' => false,
            ],
        ]);

        $html = (string) $view;

        $this->assertStringContainsString('<link rel="stylesheet" href="/_resources/css/main.css">', $html);
        $this->assertStringNotContainsString('_resources/css/404.css', $html);
        $this->assertSame(1, substr_count($html, '<script src='));
    }
}
