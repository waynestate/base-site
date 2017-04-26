<?php

namespace Tests\App\Repositories;

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
        $name_fields = app('App\Repositories\ProfileRepository')->getFields()['name_fields'];

        // Build the return set
        foreach ((array) $name_fields as $name) {
            $return['profile']['data'][$name] = $this->faker->word;
        }

        // Get the page title
        $pageTitle = app('App\Repositories\ProfileRepository')->getPageTitleFromName($return);

        // Make sure the page title equals all the name fields
        $this->assertEquals(implode($return['profile']['data'], ' '), $pageTitle);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getBackToProfileListUrl
     * @test
     */
    public function getting_back_to_profile_list_url_should_return_url()
    {
        // The default path if no referer
        $url = app('App\Repositories\ProfileRepository')->getBackToProfileListUrl();
        $this->assertTrue($url == config('app.profile_default_back_url'));

        // If a referer is passed from a different domain
        $referer = $this->faker->url;
        $url = app('App\Repositories\ProfileRepository')->getBackToProfileListUrl($referer, 'http', 'wayne.edu', '/');
        $this->assertTrue($url == config('app.profile_default_back_url'));

        // If a referer is passed that is the same page we are on
        $referer = $this->faker->url;
        $parsed = parse_url($referer);
        $url = app('App\Repositories\ProfileRepository')->getBackToProfileListUrl($referer, $parsed['scheme'], $parsed['host'], $parsed['path']);
        $this->assertTrue($url == config('app.profile_default_back_url'));

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
    public function getting_dropdown_of_groups_shoudl_contain_all_the_groups()
    {
        // Fake return
        $return = [
            'results' => app('Factories\ProfileGroup')->create(5),
        ];

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('profile.groups.listing', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $dropdown = app('App\Repositories\ProfileRepository', [$wsuApi])->getDropdownOfGroups($this->faker->numberBetween(1, 10));

        collect($return['results'])->each(function ($item) use ($dropdown) {
            // Make sure the group exists in the dropdown array
            $this->assertTrue(in_array($item['display_name'], current($dropdown)));
        });
    }

    /**
     * @covers App\Repositories\ProfileRepository::getProfile
     * @test
     */
    public function getting_profile_that_doesnt_exist_should_return_null()
    {
        $site_id = $this->faker->numberBetween(1, 10);
        $invalid_site_id = $this->faker->numberBetween(20, 30);
        $accessid = $this->faker->word;

        // Fake return
        $return = [
            'profiles' => [
                $invalid_site_id => app('Factories\Profile')->create(1),
            ],
        ];

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.view', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $profile = app('App\Repositories\ProfileRepository', [$wsuApi])->getProfile($site_id, $accessid);

        $this->assertNull($profile['profile']);
    }

    /**
     * @covers App\Repositories\ProfileRepository::getProfiles
     * @test
     */
    public function getting_profiles_with_api_error_should_return_blank_array()
    {
        // Fake return
        $return = app('Factories\ApiError')->create(1);

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.listing', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        $profiles = app('App\Repositories\ProfileRepository', [$wsuApi])->getProfiles($this->faker->numberBetween(1, 10));

        // Since the API returned an error we shouldn't have any profiles
        $this->assertEmpty($profiles['profiles']);
    }
}
