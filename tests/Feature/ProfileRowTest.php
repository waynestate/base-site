<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ProfileRowTest extends TestCase
{
    #[Test]
    public function profile_row_renders_photo_and_name_linked_with_default_h2(): void
    {
        config(['base.profile.listing_fields' => ['Title']]);

        $profile = [
            'link' => '/profile/ab1234',
            'full_name' => 'Jane Doe',
            'data' => [
                'Picture' => [
                    'url' => '/images/jane.jpg',
                ],
                'Title' => 'Assistant Professor',
            ],
        ];

        $rendered = view('components.profile-row', [
            'profile' => $profile,
        ])->render();

        $this->assertStringContainsString('href="/profile/ab1234"', $rendered);
        $this->assertStringContainsString('/images/jane.jpg', $rendered);
        $this->assertStringContainsString('<h2', $rendered);
        $this->assertStringContainsString('Jane Doe', $rendered);
        $this->assertStringContainsString('Assistant Professor', $rendered);
        $this->assertStringContainsString('w-1/3 md:w-1/4', $rendered);
    }

    #[Test]
    public function profile_row_respects_custom_heading_level(): void
    {
        $profile = [
            'link' => '/profile/cd5678',
            'full_name' => 'John Smith',
            'data' => [
                'Picture' => null,
                'Title' => 'Chair',
            ],
        ];

        $rendered = view('components.profile-row', [
            'profile' => $profile,
            'headingLevel' => 'h3',
        ])->render();

        $this->assertStringContainsString('<h3', $rendered);
        $this->assertStringNotContainsString('<h2', $rendered);
        $this->assertStringContainsString('John Smith', $rendered);
    }

    #[Test]
    public function profile_listing_renders_single_column_or_grid_based_on_config(): void
    {
        $viewData = [
            'base' => [
                'layout' => 'main',
                'page' => [
                    'title' => 'Faculty Experts',
                    'controller' => 'ProfileController',
                    'content' => ['main' => ''],
                ],
                'show_header' => false,
                'show_site_menu' => false,
            ],
            'hide_filtering' => true,
            'profiles' => [
                [
                    'link' => '/profile/aa1111',
                    'full_name' => 'Alice Wonder',
                    'data' => [
                        'Picture' => null,
                        'Title' => 'Professor',
                    ],
                ],
            ],
        ];

        // 1 column
        config(['base.profile.columns' => 1]);
        $rendered1 = view('profile-listing', $viewData)->render();
        $this->assertStringContainsString('divide-y divide-gray-200', $rendered1);
        $this->assertStringContainsString('<h2', $rendered1);
        $this->assertStringContainsString('Alice Wonder', $rendered1);

        // 2 columns
        config(['base.profile.columns' => 2]);
        $rendered2 = view('profile-listing', $viewData)->render();
        $this->assertStringContainsString('grid grid-cols-2', $rendered2);
        $this->assertStringNotContainsString('md:grid-cols-3', $rendered2);

        // 3 columns
        config(['base.profile.columns' => 3]);
        $rendered3 = view('profile-listing', $viewData)->render();
        $this->assertStringContainsString('grid grid-cols-2 md:grid-cols-3', $rendered3);
        $this->assertStringNotContainsString('xl:grid-cols-4', $rendered3);

        // 4 columns (default)
        config(['base.profile.columns' => 4]);
        $rendered4 = view('profile-listing', $viewData)->render();
        $this->assertStringContainsString('grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4', $rendered4);
    }

    #[Test]
    public function directory_renders_single_column_or_grid_based_on_config(): void
    {
        $viewData = [
            'base' => [
                'layout' => 'main',
                'page' => [
                    'title' => 'Directory',
                    'controller' => 'DirectoryController',
                    'content' => ['main' => ''],
                ],
                'show_header' => false,
                'show_site_menu' => false,
            ],
            'profiles' => [
                'Department of Testing' => [
                    [
                        'link' => '/profile/bb2222',
                        'full_name' => 'Bob Tester',
                        'data' => [
                            'Picture' => null,
                            'Title' => 'Lecturer',
                        ],
                    ],
                ],
            ],
        ];

        // 1 column - should use h3 for profile name since department title is h2
        config(['base.profile.columns' => 1]);
        $rendered1 = view('directory', $viewData)->render();
        $this->assertStringContainsString('divide-y divide-gray-200', $rendered1);
        $this->assertStringContainsString('<h2>Department of Testing</h2>', $rendered1);
        $this->assertStringContainsString('<h3', $rendered1);
        $this->assertStringContainsString('Bob Tester', $rendered1);

        // 2 columns
        config(['base.profile.columns' => 2]);
        $rendered2 = view('directory', $viewData)->render();
        $this->assertStringContainsString('grid grid-cols-2', $rendered2);
        $this->assertStringNotContainsString('md:grid-cols-3', $rendered2);

        // 3 columns
        config(['base.profile.columns' => 3]);
        $rendered3 = view('directory', $viewData)->render();
        $this->assertStringContainsString('grid grid-cols-2 md:grid-cols-3', $rendered3);
        $this->assertStringNotContainsString('xl:grid-cols-4', $rendered3);

        // 4 columns (default)
        config(['base.profile.columns' => 4]);
        $rendered4 = view('directory', $viewData)->render();
        $this->assertStringContainsString('grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4', $rendered4);
    }
}
