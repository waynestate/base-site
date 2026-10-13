<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class StyleguideButtonsLargeTest extends TestCase
{
    #[Test]
    public function default_buttons_page_does_not_render_large_buttons(): void
    {
        $response = $this->call('GET', '/styleguide/component/buttons');

        $response->assertStatus(200);
        $this->assertStringNotContainsString('button--large', $response->getContent());
    }

    #[Test]
    public function default_buttons_page_renders_under_menu_buttons(): void
    {
        $response = $this->call('GET', '/styleguide/component/buttons');

        $response->assertStatus(200);
        $this->assertStringContainsString('class="under-menu"', $response->getContent());
    }

    #[Test]
    public function large_buttons_page_renders_large_buttons_and_config(): void
    {
        $response = $this->call('GET', '/styleguide/component/buttonslarge');

        $response->assertStatus(200);
        $this->assertStringContainsString('button--large', $response->getContent());
        $this->assertStringContainsString('"buttonSize":"large"', $response->getContent());
    }

    #[Test]
    public function default_hero_buttons_page_does_not_render_large_buttons(): void
    {
        $response = $this->call('GET', '/styleguide/component/hero/buttons');

        $response->assertStatus(200);
        $this->assertStringNotContainsString('button--large', $response->getContent());
    }

    #[Test]
    public function large_hero_buttons_page_renders_large_buttons_and_config(): void
    {
        $response = $this->call('GET', '/styleguide/component/hero/buttonslarge');

        $response->assertStatus(200);
        $this->assertStringContainsString('button--large', $response->getContent());
        $this->assertStringContainsString('"buttonSize":"large"', $response->getContent());
    }
}
