<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class StyleguideHeroVideoTest extends TestCase
{
    #[Test]
    public function hero_video_styleguide_page_renders_successfully(): void
    {
        $response = $this->call('GET', '/styleguide/component/hero/video');

        $response->assertStatus(200);

        $content = $response->getContent();

        $this->assertStringContainsString('hero--video', $content);
        $this->assertStringContainsString('id="js-video-hero"', $content);
        $this->assertStringContainsString('id="js-play-pause-btn"', $content);
        $this->assertStringContainsString('id="js-video-state"', $content);
        $this->assertStringContainsString('id="js-video-status"', $content);
        $this->assertStringContainsString('id="js-play-icon"', $content);
        $this->assertStringContainsString('id="js-pause-icon"', $content);
        $this->assertStringContainsString('community-connected-720p.webm', $content);
        $this->assertStringContainsString('community-connected-frame1.jpg', $content);
        $this->assertStringContainsString('class="hero__secondary-image"', $content);
        $this->assertStringContainsString('"option":"video"', $content);
    }
}
