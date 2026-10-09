<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class StyleguideToolbarTest extends TestCase
{
    #[Test]
    public function toolbar_is_rendered_when_in_styleguide_on_base_with_available_sites(): void
    {
        config(['app.name' => 'base']);

        $view = $this->view('childpage', [
            'base' => [
                'page' => [
                    'controller' => 'ChildpageController',
                    'title' => 'Styleguide Page',
                    'content' => ['main' => '<p>Hello</p>'],
                ],
                'layout' => 'main',
                'show_header' => false,
                'show_site_menu' => false,
                'styleguide_sites' => [
                    'nursing' => 'Nursing',
                    'president' => 'President',
                ],
                'styleguide_selected_site' => 'nursing',
            ],
        ]);

        $html = (string) $view;

        $this->assertStringContainsString('id="styleguide-toolbar"', $html);
        $this->assertStringContainsString('id="styleguide-site-select"', $html);
        $this->assertStringContainsString('Default (Base)', $html);
        $this->assertStringContainsString('value="nursing"', $html);
        $this->assertStringContainsString('Nursing', $html);
        $this->assertStringContainsString('value="president"', $html);
        $this->assertStringContainsString('President', $html);
        $this->assertStringContainsString('<option value="nursing" selected', $html);
    }

    #[Test]
    public function toolbar_is_not_rendered_when_styleguide_sites_is_empty(): void
    {
        config(['app.name' => 'base']);

        $view = $this->view('childpage', [
            'base' => [
                'page' => [
                    'controller' => 'ChildpageController',
                    'title' => 'Styleguide Page',
                    'content' => ['main' => '<p>Hello</p>'],
                ],
                'layout' => 'main',
                'show_header' => false,
                'show_site_menu' => false,
                'styleguide_sites' => [],
                'styleguide_selected_site' => null,
            ],
        ]);

        $html = (string) $view;

        $this->assertStringNotContainsString('id="styleguide-toolbar"', $html);
    }

    #[Test]
    public function toolbar_is_not_rendered_when_not_on_base_domain(): void
    {
        config(['app.name' => 'nursing']);

        $view = $this->view('childpage', [
            'base' => [
                'page' => [
                    'controller' => 'ChildpageController',
                    'title' => 'Styleguide Page',
                    'content' => ['main' => '<p>Hello</p>'],
                ],
                'layout' => 'main',
                'show_header' => false,
                'show_site_menu' => false,
                'styleguide_sites' => [
                    'nursing' => 'Nursing',
                ],
                'styleguide_selected_site' => null,
            ],
        ]);

        $html = (string) $view;

        $this->assertStringNotContainsString('id="styleguide-toolbar"', $html);
    }
}
