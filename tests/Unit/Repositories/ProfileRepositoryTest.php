<?php

namespace Tests\Unit\Repositories;

use App\Repositories\ProfileRepository;
use Factories\ApiError;
use Factories\Article;
use Factories\Page;
use Factories\Profile;
use Factories\ProfileGroup;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Support\Str;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;
use Waynestate\Api\News;

class ProfileRepositoryTest extends TestCase
{
    /**
     * @covers App\Repositories\ProfileRepository::__construct
     * @covers App\Repositories\ProfileRepository::getDropdownOptions
     * @test
     */
    public function getting_dropdown_options_should_return_options(): void
    {
        // Get a random group id
        $random_group_id = $this->faker->numberBetween(1, 9);

        // No parameters
        $options = app(ProfileRepository::class)->getDropdownOptions();
        $this->assertEquals(['selected_group' => null, 'hide_filtering' => false], $options);

        // If user selects group
        $options = app(ProfileRepository::class)->getDropdownOptions($random_group_id);
        $this->assertEquals(['selected_group' => $random_group_id, 'hide_filtering' => false], $options);

        // If custom page fields selects the group
        $options = app(ProfileRepository::class)->getDropdownOptions(null, $random_group_id);
        $this->assertEquals(['selected_group' => $random_group_id, 'hide_filtering' => true], $options);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getFields
     * @test
     */
    public function getting_fields_should_return_all_types(): void
    {
        $fields = app(ProfileRepository::class)->getFields();

        $this->assertTrue(is_array($fields));
    }

    /**
     * @covers App\Repositories\ProfileRepository::getPageTitleFromName
     * @test
     */
    public function getting_page_title_should_come_from_name(): void
    {
        $returnNameFields = [
            'name_fields' => [
                'Honorific',
                'First Name',
                'Last Name',
                'Suffix',
            ],
        ];

        $return['profile']['data'] = [
            'Honorific' => 'Dr.',
            'First Name' => 'Anthony',
            'Last Name' => 'Wayne',
            'Suffix' => 'Jr.',
        ];

        // Mock the Connector and set the return
        $profile = Mockery::mock(ProfileRepository::class)->makePartial();
        $profile->shouldReceive('getFields')->once()->andReturn($returnNameFields);

        // Get the page title
        $pageTitle = $profile->getPageTitleFromName($return);

        // Make sure the page title equals all the name fields
        $this->assertEquals('Dr. Anthony Wayne, Jr.', $pageTitle);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getBackToProfileListUrl
     * @test
     */
    public function getting_back_to_profile_list_url_should_return_url(): void
    {
        // The default path if no referer
        $url = app(ProfileRepository::class)->getBackToProfileListUrl();
        $this->assertTrue($url == config('base.profile_default_back_url'));

        // If a referer is passed from a different domain
        $referer = $this->faker->url();
        $url = app(ProfileRepository::class)->getBackToProfileListUrl($referer, 'http', 'wayne.edu', '/');
        $this->assertTrue($url == config('base.profile_default_back_url'));

        // If a referer is passed that is the same page we are on
        $referer = $this->faker->url();
        $parsed = parse_url($referer);
        $url = app(ProfileRepository::class)->getBackToProfileListUrl($referer, $parsed['scheme'], $parsed['host'], $parsed['path']);
        $this->assertTrue($url == config('base.profile_default_back_url'));

        // If referer is passed from the same domain that the site is on
        $referer = $this->faker->url();
        $parsed = parse_url($referer);
        $url = app(ProfileRepository::class)->getBackToProfileListUrl($referer, $parsed['scheme'], $parsed['host'], $this->faker->word());
        $this->assertEquals($referer, $url);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getDropdownOfGroups
     * @test
     */
    public function getting_dropdown_of_groups_should_contain_all_the_groups(): void
    {
        // Force this config incase it is changed
        config(['base.profile_parent_group_id' => 0]);

        // Fake return
        $return = [
            'results' => app(ProfileGroup::class)->create(5),
        ];

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('profile.groups.listing', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $dropdown = app(ProfileRepository::class, ['wsuApi' => $wsuApi])->getDropdownOfGroups($this->faker->numberBetween(1, 10));

        $this->assertArrayNotHasKey('single_group', $dropdown);
        collect($return['results'])->each(function ($item) use ($dropdown) {
            // Make sure the group exists in the dropdown array
            $this->assertTrue(in_array($item['display_name'], current($dropdown)));
        });
    }

    /**
     * @covers App\Repositories\ProfileRepository::getDropdownOfGroups
     * @test
     */
    public function getting_dropdown_of_single_group_should_contain_single_group(): void
    {
        // Force this config incase it is changed
        config(['base.profile_parent_group_id' => 0]);

        // Fake return
        $return = [
            'results' => app(ProfileGroup::class)->create(1),
        ];
        $group_id = current($return['results'])['id'];

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('profile.groups.listing', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $dropdown = app(ProfileRepository::class, ['wsuApi' => $wsuApi])->getDropdownOfGroups($this->faker->numberBetween(1, 10));

        // Make sure the single_group key exists with the ID of the group on it
        $this->assertArrayHasKey('single_group', $dropdown);
        $this->assertTrue($dropdown['single_group'] == $group_id);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getProfile
     * @test
     */
    public function getting_profile_that_doesnt_exist_should_return_blank_array(): void
    {
        $site_id = $this->faker->numberBetween(1, 10);
        $accessid = $this->faker->word();

        // Fake return
        $return = app(ApiError::class)->create(1, true);

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.view', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $profile = app(ProfileRepository::class, ['wsuApi' => $wsuApi])->getProfile($site_id, $accessid);

        $this->assertTrue(is_array($profile['profile']) && count($profile['profile']) == 0) ;
    }

    /**
     * @covers App\Repositories\ProfileRepository::getProfile
     * @test
     */
    public function getting_profile_that_exists_should_return_two_arrays(): void
    {
        $site_id = $this->faker->numberBetween(1, 10);
        $accessid = $this->faker->word();

        // Fake return
        $return = [
            'profiles' => [$site_id => []],
            'courses' => [],
        ];

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.view', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $profile = app(ProfileRepository::class, ['wsuApi' => $wsuApi])->getProfile($site_id, $accessid);

        $this->assertTrue(is_array($profile['profile']) && is_array($profile['courses'])) ;
    }

    /**
     * @covers App\Repositories\ProfileRepository::getProfiles
     * @test
     */
    public function getting_profiles_with_api_error_should_return_blank_array(): void
    {
        // Fake return
        $return = app(ApiError::class)->create(1, true);

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.listing', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $profiles = app(ProfileRepository::class, ['wsuApi' => $wsuApi])->getProfiles($this->faker->numberBetween(1, 10));

        // Since the API returned an error we shouldn't have any profiles
        $this->assertEmpty($profiles['profiles']);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getProfiles
     * @test
     */
    public function getting_profiles_should_append_link(): void
    {
        // Fake return
        $return = app(Profile::class)->create(5);

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.listing', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $profiles = app(ProfileRepository::class, ['wsuApi' => $wsuApi])->getProfiles($this->faker->numberBetween(1, 10));

        collect($profiles['profiles'])->each(function ($item) {
            $this->assertTrue(!empty($item['link']));
        });
    }

    /**
     * @covers App\Repositories\ProfileRepository::getGroupIds
     * @test
     */
    public function getting_profile_group_ids_should_return_correct_string(): void
    {
        // Fake a dropdown array of group_id => group name
        $limit = $this->faker->numberBetween(1, 10);
        $dropdown = $this->faker->words($limit, false);

        // If no forced ID and no selection has been made the result should be all group_ids from the dropdown
        $group_ids = app(ProfileRepository::class)->getGroupIds(null, null, $dropdown);
        $this->assertEquals(implode('|', array_keys($dropdown)), $group_ids);

        // Forcing a group ID
        $forced_id = $this->faker->numberBetween(0, $limit - 1);
        $group_ids = app(ProfileRepository::class)->getGroupIds(null, $forced_id, $dropdown);
        $this->assertEquals($forced_id, $group_ids);

        // Selected from the dropdown
        $selected = array_rand($dropdown, 1);
        $group_ids = app(ProfileRepository::class)->getGroupIds($selected, null, $dropdown);
        $this->assertEquals($selected, $group_ids);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getProfilesByGroup
     * @covers App\Repositories\ProfileRepository::sortGroupsByDisplayOrder
     * @test
     */
    public function profiles_should_be_grouped(): void
    {
        // Force this config incase it is changed
        config(['base.profile_parent_group_id' => 0]);

        // Mock the user listing
        $return_user_listing = app(Profile::class)->create(10);
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.listing', Mockery::type('array'))->once()->andReturn($return_user_listing);

        // The Profile factory creates groups. We need those values rather than factoring more groups that users aren't in.
        $return_group_listing['results'] = collect($return_user_listing)
            ->map(function ($item, $key) {
                return [
                    'parent_id' => 0,
                    'display_order' => $key,
                    'display_name' => collect($item['groups'])->first(),
                ];
            })
            ->toArray();

        // Mock the groups listing
        $wsuApi->shouldReceive('sendRequest')->with('profile.groups.listing', Mockery::type('array'))->once()->andReturn($return_group_listing);
        $wsuApi->shouldReceive('nextRequestProduction')->twice();

        $profiles = app(ProfileRepository::class, ['wsuApi' => $wsuApi])->getProfilesByGroup($this->faker->numberBetween(1, 10));

        // Make sure the root keys are all of the groups
        collect($return_group_listing['results'])->each(function ($item) use ($profiles) {
            $this->assertTrue(array_key_exists($item['display_name'], $profiles['profiles']));
        });
    }

    /**
     * @covers App\Repositories\ProfileRepository::getProfilesByGroupOrder
     * @test
     */
    public function profile_group_ids_should_return_ordered_array(): void
    {
        // Mock the user listing
        $return_user_listing = app(Profile::class)->create(10);

        $groups = collect($return_user_listing)->map(function ($item) {
            return array_shift($item['groups']);
        })->unique()->reverse()->toArray();

        $piped_groups = implode('|', array_keys($groups));

        $return_user_listing = collect($return_user_listing)->mapWithKeys(function ($item, $key) use ($groups) {
            $group_id = array_search($item['groups'][0], $groups);
            $item['groups'] = [$group_id => $item['groups'][0]];

            return [$key => $item];
        });

        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.listing', Mockery::type('array'))->once()->andReturn($return_user_listing);

        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $profiles = app(ProfileRepository::class, ['wsuApi' => $wsuApi])->getProfilesByGroupOrder($this->faker->numberBetween(1, 10), $piped_groups);

        $this->assertEquals(array_values($groups), array_values(array_keys($profiles['profiles'])));

        $this->assertEquals(array_values($groups), array_values(array_keys($profiles['anchors'])));

        foreach ($profiles['anchors'] as $key => $slug) {
            $this->assertEquals($slug, Str::slug($key));
        }
    }

    /**
     * @covers App\Repositories\ProfileRepository::getSiteID
     * @test
     */
    public function getting_profile_site_id_should_return_the_correct_site_id_based_on_custom_field(): void
    {
        // Mock WSU API
        $wsuApi = Mockery::mock(Connector::class);

        // Create a fake data request for custom page field data
        $profile_site_id = $this->faker->numberBetween(1, 1000);
        $custom_field_page = app(Page::class)->create(1, true, [
            'data' => [
                'profile_site_id' => $profile_site_id,
            ],
        ]);
        $return_profile_site_id = app(ProfileRepository::class, ['wsuApi' => $wsuApi])->getSiteID($custom_field_page);
        $this->assertEquals($profile_site_id, $return_profile_site_id);

        // Create a fake data request for site config people id
        $site_config_page = app(Page::class)->create(1, true);
        $cms_site_id = $site_config_page['site']['id'];

        $return_cms_site_id = app(ProfileRepository::class, ['wsuApi' => $wsuApi])->getSiteID($site_config_page);

        $this->assertEquals($cms_site_id, $return_cms_site_id);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getNewsArticles
     * @test
     */
    public function getting_profile_should_get_articles(): void
    {
        // Fake return
        $return = app(Article::class)->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        // Get the articles
        $articles = app(ProfileRepository::class, ['newsApi' => $newsApi])->getNewsArticles('aa0000');

        $this->assertEquals($return['data'], $articles);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getNewsArticles
     * @test
     */
    public function getting_profile_articles_should_be_empty_if_exception_was_thrown(): void
    {
        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andThrow(new TransferException('test'));

        // Get the articles
        $articles = app(ProfileRepository::class, ['newsApi' => $newsApi])->getNewsArticles('aa0000');

        $this->assertEmpty($articles);
    }

    /**
    * @covers App\Repositories\ProfileRepository::getProfile
    * @test
    */
    public function getting_profile_should_get_youtube_videos(): void
    {
        $site_id = $this->faker->numberBetween(1, 10);
        $accessid = $this->faker->randomLetter().$this->faker->randomLetter().$this->faker->randomNumber(4, true);

        $profile = app(Profile::class)->create(1, true);
        $profile['data']['AccessID'] = $accessid;

        // Fake return
        $return = [
            'profiles' => [$site_id => $profile],
            'courses' => [],
        ];

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.view', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $profile = app(ProfileRepository::class, ['wsuApi' => $wsuApi])->getProfile($site_id, $accessid);

        $this->assertTrue(is_array($profile['profile']['data']['Youtube Videos']));

        foreach ($profile['profile']['data']['Youtube Videos'] as $video) {
            $this->assertTrue(array_key_exists('youtube_id', $video));
        }
    }
}
