<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ProfileFieldTest extends TestCase
{
    #[Test]
    public function email_field_renders_mailto_link(): void
    {
        $rendered = view('components.profile-field', [
            'field' => 'Email',
            'data' => 'jane@wayne.edu',
        ])->render();

        $this->assertStringContainsString('<a href="mailto:jane@wayne.edu">jane@wayne.edu</a>', $rendered);
    }

    #[Test]
    public function email_field_renders_plain_text_when_link_is_false(): void
    {
        $rendered = view('components.profile-field', [
            'field' => 'Email',
            'data' => 'jane@wayne.edu',
            'link' => false,
        ])->render();

        $this->assertStringNotContainsString('<a href="mailto:', $rendered);
        $this->assertStringContainsString('jane@wayne.edu', $rendered);
    }

    #[Test]
    public function url_field_renders_link(): void
    {
        config(['base.profile.url_fields' => ['Website']]);

        $rendered = view('components.profile-field', [
            'field' => 'Website',
            'data' => 'https://wayne.edu',
        ])->render();

        $this->assertStringContainsString('<a href="https://wayne.edu">https://wayne.edu</a>', $rendered);
    }

    #[Test]
    public function url_field_renders_plain_text_when_link_is_false(): void
    {
        config(['base.profile.url_fields' => ['Website']]);

        $rendered = view('components.profile-field', [
            'field' => 'Website',
            'data' => 'https://wayne.edu',
            'link' => false,
        ])->render();

        $this->assertStringNotContainsString('<a href="https://wayne.edu">', $rendered);
        $this->assertStringContainsString('https://wayne.edu', $rendered);
    }

    #[Test]
    public function file_field_renders_file_link_using_field_name_as_text(): void
    {
        config(['base.profile.file_fields' => ['Curriculum Vitae']]);

        $rendered = view('components.profile-field', [
            'field' => 'Curriculum Vitae',
            'data' => ['url' => 'https://example.com/cv.pdf'],
        ])->render();

        $this->assertStringContainsString('<a href="https://example.com/cv.pdf">Curriculum Vitae</a>', $rendered);
    }

    #[Test]
    public function fax_field_renders_fax_suffix(): void
    {
        $rendered = view('components.profile-field', [
            'field' => 'Fax',
            'data' => '313-577-0000',
        ])->render();

        $this->assertStringContainsString('313-577-0000 (fax)', $rendered);
    }

    #[Test]
    public function default_field_preserves_line_breaks_and_strips_other_tags(): void
    {
        $rendered = view('components.profile-field', [
            'field' => 'Title',
            'data' => '<strong>Associate Professor</strong><br><p>Director</p>',
        ])->render();

        $this->assertStringNotContainsString('<strong>', $rendered);
        $this->assertStringNotContainsString('<p>', $rendered);
        $this->assertStringContainsString('Associate Professor<br>Director', $rendered);
    }

    #[Test]
    public function multi_value_field_renders_each_item(): void
    {
        $rendered = view('components.profile-field', [
            'field' => 'Email',
            'data' => ['first@wayne.edu', 'second@wayne.edu'],
        ])->render();

        $this->assertStringContainsString('<a href="mailto:first@wayne.edu">first@wayne.edu</a>', $rendered);
        $this->assertStringContainsString('<a href="mailto:second@wayne.edu">second@wayne.edu</a>', $rendered);
    }

    #[Test]
    public function custom_tag_and_classes_are_applied(): void
    {
        $rendered = view('components.profile-field', [
            'field' => 'Title',
            'data' => 'Professor',
            'tag' => 'div',
            'class' => 'text-black text-sm',
        ])->render();

        $this->assertStringContainsString('<div class="text-black text-sm">', $rendered);
        $this->assertStringContainsString('Professor', $rendered);
        $this->assertStringContainsString('</div>', $rendered);
    }

    #[Test]
    public function youtube_videos_renders_video_markup(): void
    {
        $rendered = view('components.profile-field', [
            'field' => 'Youtube Videos',
            'data' => [
                [
                    'youtube_id' => 'PHqfwq033yQ',
                    'link' => 'https://www.youtube.com/watch?v=PHqfwq033yQ',
                    'filename_alt_text' => 'YouTube video from Jane',
                ],
            ],
        ])->render();

        $this->assertStringContainsString('https://www.youtube.com/watch?v=PHqfwq033yQ', $rendered);
        $this->assertStringContainsString('//i.wayne.edu/youtube/PHqfwq033yQ', $rendered);
    }

    #[Test]
    public function email_with_tag_renders_wrapped_link(): void
    {
        $rendered = view('components.profile-field', [
            'field' => 'Email',
            'data' => 'jane@wayne.edu',
            'tag' => 'p',
        ])->render();

        $this->assertMatchesRegularExpression('/<p[^>]*>\s*<a href="mailto:jane@wayne.edu">jane@wayne.edu<\/a>\s*<\/p>/', $rendered);
    }

    #[Test]
    public function styleguide_profile_view_renders_successfully(): void
    {
        $response = $this->call('GET', '/styleguide/profile/aa0000');

        $this->assertEquals(200, $response->getStatusCode());
    }

    #[Test]
    public function styleguide_profiles_listing_renders_successfully(): void
    {
        $response = $this->call('GET', '/styleguide/profiles');

        $this->assertEquals(200, $response->getStatusCode());
    }

    #[Test]
    public function styleguide_directory_renders_successfully(): void
    {
        $response = $this->call('GET', '/styleguide/directory');

        $this->assertEquals(200, $response->getStatusCode());
    }

    #[Test]
    public function profile_card_renders_anchor_wrapping_only_photo_and_name(): void
    {
        $profile = [
            'link' => '/profile/aa1234',
            'full_name' => 'Anthony Wayne',
            'data' => [
                'AccessID' => 'aa1234',
                'Title' => 'General',
                'Email' => 'anthony@wayne.edu',
                'Picture' => ['url' => '/images/anthony.jpg'],
            ],
        ];

        config(['base.profile.listing_fields' => ['Title', 'Email']]);

        $rendered = view('components.profile', ['profile' => $profile])->render();

        // Ensure anchor closes after name and does not enclose listing fields
        $parts = explode('</a>', $rendered);
        $this->assertStringContainsString('Anthony Wayne', $parts[0]);
        $this->assertStringNotContainsString('<a href="mailto:', $parts[0]);
        $this->assertStringContainsString('<a href="mailto:anthony@wayne.edu">anthony@wayne.edu</a>', $rendered);
    }

    #[Test]
    public function empty_data_renders_nothing_even_with_tag(): void
    {
        $rendered = view('components.profile-field', [
            'field' => 'Title',
            'data' => '',
            'tag' => 'p',
        ])->render();

        $this->assertEquals('', trim($rendered));
    }

    #[Test]
    public function multi_value_field_filters_out_empty_items(): void
    {
        $rendered = view('components.profile-field', [
            'field' => 'Email',
            'data' => ['first@wayne.edu', '', null, 'second@wayne.edu'],
            'tag' => 'p',
        ])->render();

        $this->assertStringContainsString('<a href="mailto:first@wayne.edu">first@wayne.edu</a>', $rendered);
        $this->assertStringContainsString('<a href="mailto:second@wayne.edu">second@wayne.edu</a>', $rendered);
        $this->assertEquals(2, substr_count($rendered, '<p>'));
    }

    #[Test]
    public function omitted_data_renders_nothing_without_errors(): void
    {
        $rendered = view('components.profile-field', [
            'field' => 'Title',
            'tag' => 'p',
        ])->render();

        $this->assertEquals('', trim($rendered));
    }

    #[Test]
    public function url_field_decodes_html_entities_in_link(): void
    {
        config(['base.profile.url_fields' => ['Google Scholar URL']]);

        $url = 'https://scholar.google.com/citations?user=abc&amp;hl=en';

        $rendered = view('components.profile-field', [
            'field' => 'Google Scholar URL',
            'data' => $url,
        ])->render();

        $this->assertStringContainsString('href="https://scholar.google.com/citations?user=abc&amp;hl=en"', $rendered);
        $this->assertStringNotContainsString('&amp;amp;', $rendered);
    }

    #[Test]
    public function file_field_decodes_html_entities_in_link(): void
    {
        $rendered = view('components.profile-field', [
            'field' => 'Curriculum Vitae',
            'data' => ['url' => 'https://wayne.edu/cv.pdf?a=1&amp;b=2'],
        ])->render();

        $this->assertStringContainsString('href="https://wayne.edu/cv.pdf?a=1&amp;b=2"', $rendered);
        $this->assertStringNotContainsString('&amp;amp;', $rendered);
    }
}
