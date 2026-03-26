<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AccessibleLinkNamesTest extends TestCase
{
    #[Test]
    public function promo_links_have_aria_labelledby_pointing_to_title_id(): void
    {
        $response = $this->call('GET', '/styleguide/component/singlepromo');
        $content = $response->content();

        // GenericPromo factory produces promo_item_id starting at 0
        $this->assertStringContainsString('id="promo-0"', $content);
        $this->assertStringContainsString('aria-labelledby="promo-0"', $content);
    }

    #[Test]
    public function icon_links_have_aria_labelledby_pointing_to_title_id(): void
    {
        $response = $this->call('GET', '/styleguide/component/icons');
        $content = $response->content();

        // Icon factory produces promo_item_id starting at 1
        $this->assertStringContainsString('id="promo-1"', $content);
        $this->assertStringContainsString('aria-labelledby="promo-1"', $content);
    }

    #[Test]
    public function news_links_have_aria_labelledby_pointing_to_title_id(): void
    {
        $response = $this->call('GET', '/styleguide/component/articlelisting');
        $content = $response->content();

        // ArticleComponent factory produces id starting at 1
        $this->assertStringContainsString('id="news-1"', $content);
        $this->assertStringContainsString('aria-labelledby="news-1"', $content);
    }

    #[Test]
    public function event_links_have_aria_labelledby_pointing_to_title_id(): void
    {
        $response = $this->call('GET', '/styleguide/component/eventlisting');
        $content = $response->content();

        // EventFullListing factory produces event_id starting at 1
        $this->assertStringContainsString('id="event-1"', $content);
        $this->assertStringContainsString('aria-labelledby="event-1"', $content);
    }

    #[Test]
    public function spotlight_links_have_aria_labelledby_pointing_to_title_id(): void
    {
        $response = $this->call('GET', '/styleguide/component/spotlight');
        $content = $response->content();

        // GenericPromo (used for the linked spotlight) produces promo_item_id starting at 0
        $this->assertStringContainsString('id="promo-0"', $content);
        $this->assertStringContainsString('aria-labelledby="promo-0"', $content);
    }

    #[Test]
    public function profile_links_have_aria_labelledby_pointing_to_title_id(): void
    {
        $response = $this->call('GET', '/styleguide/profiles');
        $content = $response->content();

        // Profile AccessID is two letters + four digits (e.g. ab1234)
        $this->assertMatchesRegularExpression('/id="profile-[a-z]{2}\d{4}"/', $content);
        $this->assertMatchesRegularExpression('/aria-labelledby="profile-[a-z]{2}\d{4}"/', $content);
    }
}
