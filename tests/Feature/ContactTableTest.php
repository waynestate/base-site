<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ContactTableTest extends TestCase
{
    private function sampleProfiles(): array
    {
        return [
            'Staff' => [
                [
                    'link' => '/profile/aa1234',
                    'full_name' => 'Anthony Wayne',
                    'data' => [
                        'AccessID' => 'aa1234',
                        'Title' => 'General',
                        'Email' => 'anthony@wayne.edu',
                        'Office' => '300 Prentis',
                        'Phone' => '313-577-0000',
                        'Department' => 'Leadership',
                        'Website' => 'https://wayne.edu',
                    ],
                ],
            ],
        ];
    }

    private function sampleViewData(): array
    {
        $request = new \Illuminate\Http\Request();
        $request = $request->create('styleguide');
        $base = [];
        app(\App\Http\Middleware\Data::class)->handle($request, function ($response) use (&$base) {
            $base = $response->data['base'];
        });

        return [
            'base' => $base,
            'profiles' => $this->sampleProfiles(),
            'anchors' => [],
        ];
    }

    #[Test]
    public function contact_table_renders_default_columns_and_links_name_to_email(): void
    {
        $rendered = view('contact-tables', $this->sampleViewData())->render();

        $this->assertStringContainsString('class="table-stack md:table-fixed w-full"', $rendered);
        $this->assertStringContainsString('<th class="w-48">Name</th>', $rendered);
        $this->assertStringContainsString('<th>Title</th>', $rendered);
        $this->assertStringContainsString('<th class="w-40">Office</th>', $rendered);
        $this->assertStringContainsString('<th class="w-40">Phone</th>', $rendered);
        $this->assertStringContainsString('<a href="mailto:anthony@wayne.edu">Anthony Wayne</a>', $rendered);
        $this->assertStringContainsString('General', $rendered);
        $this->assertStringContainsString('300 Prentis', $rendered);
        $this->assertStringContainsString('313-577-0000', $rendered);
    }

    #[Test]
    public function contact_table_links_name_to_profile_when_single_profile_view_is_true(): void
    {
        config(['base.profile.singleProfileView' => true]);

        $rendered = view('contact-tables', $this->sampleViewData())->render();

        $this->assertStringContainsString('<a href="/profile/aa1234">Anthony Wayne</a>', $rendered);
        $this->assertStringNotContainsString('<a href="mailto:anthony@wayne.edu">', $rendered);
    }

    #[Test]
    public function contact_table_links_name_to_profile_when_table_name_link_is_profile(): void
    {
        config(['base.profile.table_name_link' => 'profile']);

        $rendered = view('contact-tables', $this->sampleViewData())->render();

        $this->assertStringContainsString('<a href="/profile/aa1234">Anthony Wayne</a>', $rendered);
        $this->assertStringNotContainsString('<a href="mailto:anthony@wayne.edu">', $rendered);
    }

    #[Test]
    public function contact_table_renders_plain_text_name_when_table_name_link_is_none(): void
    {
        config(['base.profile.table_name_link' => 'none']);

        $rendered = view('contact-tables', $this->sampleViewData())->render();

        $this->assertStringNotContainsString('<a href="/profile/aa1234">Anthony Wayne</a>', $rendered);
        $this->assertStringNotContainsString('<a href="mailto:anthony@wayne.edu">Anthony Wayne</a>', $rendered);
        $this->assertStringContainsString('Anthony Wayne', $rendered);
    }

    #[Test]
    public function contact_table_renders_custom_columns(): void
    {
        config(['base.profile.table_fields' => ['Department', 'Email', 'Website']]);

        $rendered = view('contact-tables', $this->sampleViewData())->render();

        $this->assertStringContainsString('<th>Department</th>', $rendered);
        $this->assertStringContainsString('<th class="w-40">Email</th>', $rendered);
        $this->assertStringContainsString('<th class="w-40">Website</th>', $rendered);
        $this->assertStringNotContainsString('<th>Office</th>', $rendered);
        $this->assertStringContainsString('Leadership', $rendered);
        $this->assertStringContainsString('<a href="https://wayne.edu">https://wayne.edu</a>', $rendered);
    }

    #[Test]
    public function styleguide_contact_tables_renders_successfully(): void
    {
        $response = $this->call('GET', '/styleguide/contacttables');

        $this->assertEquals(200, $response->getStatusCode());
    }

    #[Test]
    public function styleguide_contact_tables_notoc_renders_successfully(): void
    {
        $response = $this->call('GET', '/styleguide/contacttablesnotoc');

        $this->assertEquals(200, $response->getStatusCode());
    }
}
