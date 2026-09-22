<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ListservSubscribeTest extends TestCase
{
    #[Test]
    public function listserv_subscribe_does_not_render_when_required_config_is_missing(): void
    {
        $rendered = view('components.listserv-subscribe-row', [
            'data' => [],
            'component' => [
                'list' => 'test-list',
                // missing form_id and sitekey
            ],
        ])->render();

        $this->assertEmpty(trim($rendered));
    }

    #[Test]
    public function listserv_subscribe_renders_form_action_and_hidden_fields(): void
    {
        $rendered = view('components.listserv-subscribe-row', [
            'data' => [
                [
                    'title' => 'Join our listserv',
                    'description' => '<p>Get weekly updates.</p>',
                ],
            ],
            'component' => [
                'list' => 'my-newsletter',
                'form_id' => '1234',
                'sitekey' => 'test-site-key',
            ],
        ])->render();

        // Form action
        $this->assertStringContainsString('action="https://forms.wayne.edu/subscriptions/?list=my-newsletter"', $rendered);

        // Hidden fields: list should be used for f_28436
        $this->assertStringContainsString('<input name="f_28431" type="hidden" value="Subscribe">', $rendered);
        $this->assertStringContainsString('<input name="f_28436" type="hidden" value="my-newsletter">', $rendered);
        $this->assertStringContainsString('<input name="last_name" type="hidden" value="">', $rendered);
        $this->assertStringContainsString('<input type="hidden" name="formy-save" value="1234">', $rendered);

        // Inputs
        $this->assertStringContainsString('id="form-1234-first_name"', $rendered);
        $this->assertStringContainsString('id="form-1234-email"', $rendered);

        // reCAPTCHA submit
        $this->assertStringContainsString('data-sitekey="test-site-key"', $rendered);
        $this->assertStringContainsString('data-callback="onSubscribeSubmit_1234"', $rendered);
    }

    #[Test]
    public function listserv_subscribe_includes_campaign_parameters_in_form_action(): void
    {
        $rendered = view('components.listserv-subscribe-row', [
            'data' => [],
            'component' => [
                'list' => 'my-newsletter',
                'form_id' => '1234',
                'sitekey' => 'test-site-key',
                'campaign' => [
                    'utm_source' => 'base',
                    'utm_medium' => 'web',
                ],
            ],
        ])->render();

        $this->assertStringContainsString('action="https://forms.wayne.edu/subscriptions/?list=my-newsletter&amp;utm_source=base&amp;utm_medium=web"', $rendered);
    }

    #[Test]
    public function listserv_subscribe_renders_h2_heading_when_no_outer_heading(): void
    {
        $rendered = view('components.listserv-subscribe-row', [
            'data' => [
                [
                    'title' => 'Subscribe to the WSU Digest',
                ],
            ],
            'component' => [
                'list' => 'digest',
                'form_id' => '5678',
                'sitekey' => 'test-site-key',
            ],
        ])->render();

        $this->assertStringContainsString('<h2 class="mb-2">', $rendered);
        $this->assertStringContainsString('Subscribe to the WSU Digest', $rendered);
        $this->assertStringNotContainsString('<h3', $rendered);
    }

    #[Test]
    public function listserv_subscribe_renders_h3_heading_when_outer_heading_exists(): void
    {
        $rendered = view('components.listserv-subscribe-row', [
            'data' => [
                [
                    'title' => 'Inner Subscription Title',
                ],
            ],
            'component' => [
                'heading' => 'Outer Section Heading',
                'list' => 'digest',
                'form_id' => '5678',
                'sitekey' => 'test-site-key',
            ],
        ])->render();

        $this->assertStringContainsString('<h3 class="mb-2">', $rendered);
        $this->assertStringContainsString('Inner Subscription Title', $rendered);
    }

    #[Test]
    public function listserv_subscribe_falls_back_to_form_heading_or_default(): void
    {
        $rendered = view('components.listserv-subscribe-row', [
            'data' => [],
            'component' => [
                'list' => 'digest',
                'form_id' => '5678',
                'sitekey' => 'test-site-key',
                'formHeading' => 'Custom Form Heading',
            ],
        ])->render();

        $this->assertStringContainsString('Custom Form Heading', $rendered);

        $defaultRendered = view('components.listserv-subscribe-row', [
            'data' => [],
            'component' => [
                'list' => 'digest',
                'form_id' => '5678',
                'sitekey' => 'test-site-key',
            ],
        ])->render();

        $this->assertStringContainsString('Subscribe to our mailing list', $defaultRendered);
    }

    #[Test]
    public function listserv_subscribe_renders_description_when_present(): void
    {
        $rendered = view('components.listserv-subscribe-row', [
            'data' => [
                [
                    'title' => 'Subscribe',
                    'description' => '<p>Monthly news and insights.</p>',
                ],
            ],
            'component' => [
                'list' => 'digest',
                'form_id' => '5678',
                'sitekey' => 'test-site-key',
            ],
        ])->render();

        $this->assertStringContainsString('<p>Monthly news and insights.</p>', $rendered);
    }

    #[Test]
    public function listserv_subscribe_collapses_image_column_when_no_image(): void
    {
        $rendered = view('components.listserv-subscribe-row', [
            'data' => [
                [
                    'title' => 'Subscribe',
                ],
            ],
            'component' => [
                'list' => 'digest',
                'form_id' => '5678',
                'sitekey' => 'test-site-key',
            ],
        ])->render();

        $this->assertStringNotContainsString('<img', $rendered);
    }

    #[Test]
    public function listserv_subscribe_renders_image_when_provided(): void
    {
        $rendered = view('components.listserv-subscribe-row', [
            'data' => [
                [
                    'title' => 'Subscribe',
                    'relative_url' => '/images/newsletter.png',
                    'filename_alt_text' => 'Newsletter illustration',
                ],
            ],
            'component' => [
                'list' => 'digest',
                'form_id' => '5678',
                'sitekey' => 'test-site-key',
            ],
        ])->render();

        $this->assertStringContainsString('src="/images/newsletter.png"', $rendered);
        $this->assertStringContainsString('alt="Newsletter illustration"', $rendered);
    }
}
