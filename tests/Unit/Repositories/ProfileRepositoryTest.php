<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Mockery as Mockery;

class ProfileRepositoryTest extends TestCase
{
    /**
     * @covers App\Repositories\ProfileRepository::__construct
     * @covers App\Repositories\ProfileRepository::getDropdownOptions
     * @test
     */
    public function getting_dropdown_options_should_return_options()
    {
        // Get a random group id
        $random_group_id = $this->faker->numberBetween(1, 9);

        // No parameters
        $options = app('App\Repositories\ProfileRepository')->getDropdownOptions();
        $this->assertEquals(['selected_group' => null, 'hide_filtering' => false], $options);

        // If user selects group
        $options = app('App\Repositories\ProfileRepository')->getDropdownOptions($random_group_id);
        $this->assertEquals(['selected_group' => $random_group_id, 'hide_filtering' => false], $options);

        // If custom page fields selects the group
        $options = app('App\Repositories\ProfileRepository')->getDropdownOptions(null, $random_group_id);
        $this->assertEquals(['selected_group' => $random_group_id, 'hide_filtering' => true], $options);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getFields
     * @test
     */
    public function getting_fields_should_return_all_types()
    {
        $fields = app('App\Repositories\ProfileRepository')->getFields();

        $this->assertTrue(is_array($fields));
    }

    /**
     * @covers App\Repositories\ProfileRepository::getPageTitleFromName
     * @test
     */
    public function getting_page_title_should_come_from_name()
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
        $profile = Mockery::mock('App\Repositories\ProfileRepository')->makePartial();
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
    public function getting_back_to_profile_list_url_should_return_url()
    {
        // The default path if no referer
        $url = app('App\Repositories\ProfileRepository')->getBackToProfileListUrl();
        $this->assertTrue($url == config('base.profile_default_back_url'));

        // If a referer is passed from a different domain
        $referer = $this->faker->url;
        $url = app('App\Repositories\ProfileRepository')->getBackToProfileListUrl($referer, 'http', 'wayne.edu', '/');
        $this->assertTrue($url == config('base.profile_default_back_url'));

        // If a referer is passed that is the same page we are on
        $referer = $this->faker->url;
        $parsed = parse_url($referer);
        $url = app('App\Repositories\ProfileRepository')->getBackToProfileListUrl($referer, $parsed['scheme'], $parsed['host'], $parsed['path']);
        $this->assertTrue($url == config('base.profile_default_back_url'));

        // If referer is passed from the same domain that the site is on
        $referer = $this->faker->url;
        $parsed = parse_url($referer);
        $url = app('App\Repositories\ProfileRepository')->getBackToProfileListUrl($referer, $parsed['scheme'], $parsed['host'], $this->faker->word);
        $this->assertEquals($referer, $url);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getDropdownOfGroups
     * @test
     */
    public function getting_dropdown_of_groups_should_contain_all_the_groups()
    {
        // Force this config incase it is changed
        config(['base.profile_parent_group_id' => 0]);

        // Fake return
        $return = [
            'results' => app('Factories\ProfileGroup')->create(5),
        ];

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('profile.groups.listing', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $dropdown = app('App\Repositories\ProfileRepository', ['wsuApi' => $wsuApi])->getDropdownOfGroups($this->faker->numberBetween(1, 10));

        collect($return['results'])->each(function ($item) use ($dropdown) {
            // Make sure the group exists in the dropdown array
            $this->assertTrue(in_array($item['display_name'], current($dropdown)));
        });
    }

    /**
     * @covers App\Repositories\ProfileRepository::getProfile
     * @test
     */
    public function getting_profile_that_doesnt_exist_should_return_blank_array()
    {
        $site_id = $this->faker->numberBetween(1, 10);
        $accessid = $this->faker->word;

        // Fake return
        $return = app('Factories\ApiError')->create(1, true);

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.view', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $profile = app('App\Repositories\ProfileRepository', ['wsuApi' => $wsuApi])->getProfile($site_id, $accessid);

        $this->assertTrue(is_array($profile['profile']) && count($profile['profile']) == 0) ;
    }

    /**
     * @covers App\Repositories\ProfileRepository::getProfiles
     * @test
     */
    public function getting_profiles_with_api_error_should_return_blank_array()
    {
        // Fake return
        $return = app('Factories\ApiError')->create(1, true);

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.listing', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $profiles = app('App\Repositories\ProfileRepository', ['wsuApi' => $wsuApi])->getProfiles($this->faker->numberBetween(1, 10));

        // Since the API returned an error we shouldn't have any profiles
        $this->assertEmpty($profiles['profiles']);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getProfiles
     * @test
     */
    public function getting_profiles_should_append_link()
    {
        // Fake return
        $return = app('Factories\Profile')->create(5);

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.listing', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $profiles = app('App\Repositories\ProfileRepository', ['wsuApi' => $wsuApi])->getProfiles($this->faker->numberBetween(1, 10));

        collect($profiles['profiles'])->each(function ($item) {
            $this->assertTrue(!empty($item['link']));
        });
    }

    /**
     * @covers App\Repositories\ProfileRepository::getGroupIds
     * @test
     */
    public function getting_profile_group_ids_should_return_correct_string()
    {
        // Fake a dropdown array of group_id => group name
        $limit = $this->faker->numberBetween(1, 10);
        $dropdown = $this->faker->words($limit, false);

        // If no forced ID and no selection has been made the result should be all group_ids from the dropdown
        $group_ids = app('App\Repositories\ProfileRepository')->getGroupIds(null, null, $dropdown);
        $this->assertEquals(implode(array_keys($dropdown), '|'), $group_ids);

        // Forcing a group ID
        $forced_id = $this->faker->numberBetween(0, $limit - 1);
        $group_ids = app('App\Repositories\ProfileRepository')->getGroupIds(null, $forced_id, $dropdown);
        $this->assertEquals($forced_id, $group_ids);

        // Selected from the dropdown
        $selected = array_rand($dropdown, 1);
        $group_ids = app('App\Repositories\ProfileRepository')->getGroupIds($selected, null, $dropdown);
        $this->assertEquals($selected, $group_ids);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getProfilesByGroup
     * @covers App\Repositories\ProfileRepository::sortGroupsByDisplayOrder
     * @test
     */
    public function profiles_should_be_grouped()
    {
        // Force this config incase it is changed
        config(['base.profile_parent_group_id' => 0]);

        // Mock the user listing
        $return_user_listing = app('Factories\Profile')->create(10);
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
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

        $profiles = app('App\Repositories\ProfileRepository', ['wsuApi' => $wsuApi])->getProfilesByGroup($this->faker->numberBetween(1, 10));

        // Make sure the root keys are all of the groups
        collect($return_group_listing['results'])->each(function ($item) use ($profiles) {
            $this->assertTrue(array_key_exists($item['display_name'], $profiles['profiles']));
        });
    }

    /**
     * @covers App\Repositories\ProfileRepository::getProfilesByGroupOrderPiped
     * @test
     */
    public function profile_group_ids_should_return_ordered_array()
    {
        // Mock the user listing
        $return_user_listing = app('Factories\Profile')->create(10);

        $groups = collect($return_user_listing)->map(function ($item) {
            return array_shift($item['groups']);
        })->unique()->toArray();

        krsort($groups);

        $piped_groups = implode('|', array_keys($groups));

        $return_user_listing = collect($return_user_listing)->mapWithKeys(function ($item, $key) use ($groups) {
            $group_id = array_search($item['groups'][0], $groups);
            $item['groups'] = [$group_id => $item['groups'][0]];

            return [$key => $item];
        });

        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.listing', Mockery::type('array'))->once()->andReturn($return_user_listing);

        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $profiles = app('App\Repositories\ProfileRepository', ['wsuApi' => $wsuApi])->getProfilesByGroupOrderPiped($this->faker->numberBetween(1, 10), $piped_groups);

        $this->assertEquals(array_values($groups), array_values(array_keys($profiles['profiles'])));
    }
}
