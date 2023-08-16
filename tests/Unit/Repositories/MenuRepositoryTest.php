<?php

namespace Tests\Unit\Repositories;

use App\Repositories\MenuRepository;
use Factories\ApiError;
use Factories\Menu;
use Factories\Page;
use Illuminate\Support\Facades\Log;
use Styleguide\Repositories\MenuRepository as StyleguideMenuRepository;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;

class MenuRepositoryTest extends TestCase
{
    /**
     * @covers \App\Repositories\MenuRepository::__construct
     * @covers \App\Repositories\MenuRepository::getMenus
     * @test
     */
    public function top_menu_enabled_should_return_top_menu(): void
    {
        // Enable top menu
        config(['base.top_menu_enabled' => true]);

        // Get a page
        $page = app(Page::class)->create(1, true);

        // Get a menu and mimic as if there were multiple
        $menu[$page['menu']['id']] = app(Menu::class)->create(5);

        // Get all the menus
        $menus = app(MenuRepository::class)->getMenus($page, $menu);

        // Make sure we have a top menu
        $this->assertTrue(is_array($menus['top_menu']['menu']));
        $this->assertTrue(!empty($menus['top_menu_output']));

        // Set it back
        config(['base.top_menu_enabled' => false]);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getMenus
     * @test
     */
    public function disable_top_menu_should_show_site_menu(): void
    {
        // Disable top menu
        config(['base.top_menu_enabled' => false]);

        // Get a page
        $page = app(Page::class)->create(1, true);

        // Get a menu and mimic as if there were multiple
        $menu[$page['menu']['id']] = app(Menu::class)->create(5);

        // Get all the menus
        $menus = app(MenuRepository::class)->getMenus($page, $menu);

        // Make sure we are always showing the site menu
        $this->assertTrue($menus['show_site_menu']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getRequestData
     * @covers \App\Repositories\MenuRepository::getAllMenus
     * @test
     */
    public function menu_api_error_should_return_empty_menu(): void
    {
        // Get an error
        $return = app(ApiError::class)->create(1, true);

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.menuitems.listing', Mockery::type('array'))->once()->andReturn($return);

        Log::shouldReceive('error')
            ->once();

        $pageData = app(Page::class)->create(1, true);

        // Get the menus
        $menus = app(MenuRepository::class, ['wsuApi' => $wsuApi])->getRequestData($pageData);

        $this->assertEmpty($menus['site_menu']['menu']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getAllMenus
     * @test
     */
    public function getting_a_menu_without_menu_items_should_not_error(): void
    {
        // Get the page data
        $data = app(Page::class)->create(1, true);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.menuitems.listing', Mockery::type('array'))->once()->andReturn([]);

        // Build the site menus
        $menus = app(StyleguideMenuRepository::class, ['wsuApi' => $wsuApi])->getAllMenus($data['site']['id'], $data['site']['parent']['id'], $data['menu']['id']);

        // Make sure there is at least the key for the page's menu id
        $this->assertArrayHasKey($data['menu']['id'], $menus);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getSiteMenu
     * @test
     */
    public function getting_site_menu_with_no_page_found_should_return_root_menu(): void
    {
        // Get a menu with child items
        $menu = app(Menu::class)->withChildItems()->create(5);

        // Get the site menu
        $site_menu = app(StyleguideMenuRepository::class)->getSiteMenu($menu);

        foreach ($site_menu['menu'] as $key => $value) {
            // Make sure each key that was returned exists as a root level item
            $this->assertTrue(!empty($menu[$key]));

            // Make sure there aren't any subitems
            $this->assertCount(0, $value['submenu']);
        }
    }

    /**
     * @covers \App\Repositories\MenuRepository::getSiteMenu
     * @test
     */
    public function getting_site_menu_with_page_selected_should_return_is_selected(): void
    {
        // Get a menu
        $menu = app(Menu::class)->create(5);

        // Set a random selected page
        $selected_page = $menu[array_rand($menu)]['page_id'];

        // Get the site menu
        $site_menu = app(MenuRepository::class)->getSiteMenu($menu, $selected_page);

        // Make sure the item is selected
        $this->assertTrue($site_menu['meta']['has_selected']);
        $this->assertTrue($site_menu['menu'][$selected_page]['is_selected']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getSiteMenu
     * @test
     */
    public function getting_site_menu_with_unknown_page_id_should_not_be_selected(): void
    {
        // Get a menu
        $menu = app(Menu::class)->create(5);

        // Get the site menu
        $site_menu = app(MenuRepository::class)->getSiteMenu($menu, 5000);

        // Make sure the item is not selected
        $this->assertFalse($site_menu['meta']['has_selected']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::trimSiteMenu
     * @test
     */
    public function trimming_site_menu_with_no_page_found_should_return_same_menu(): void
    {
        // Get a menu
        $menu = app(Menu::class)->create(5);

        // Get the site menu
        $site_menu = app(MenuRepository::class)->getSiteMenu($menu);

        // Get the trimmed menu
        $trimmed = app(MenuRepository::class)->trimSiteMenu($site_menu);

        // Make sure the menus are the same
        $this->assertEquals($site_menu, $trimmed);
    }

    /**
     * @covers \App\Repositories\MenuRepository::trimSiteMenu
     * @test
     */
    public function trimming_selected_site_menu_with_no_children_should_return_no_trimmed_menu(): void
    {
        $currentConfig = config('base.top_menu_enabled');

        // Force enable top menu
        config(['base.top_menu_enabled' => true]);

        // Get a menu
        $menu = app(Menu::class)->create(5);

        // Get the site menu
        $site_menu = app(MenuRepository::class)->getSiteMenu($menu, 1);

        // Get the trimmed menu
        $trimmed = app(MenuRepository::class)->trimSiteMenu($site_menu);

        // Make sure the menus are the same
        $this->assertEquals($trimmed['menu'], []);

        // Set it back
        config(['base.top_menu_enabled' => $currentConfig]);
    }

    /**
     * @covers \App\Repositories\MenuRepository::trimSiteMenu
     * @test
     */
    public function trimming_site_menu_while_on_main_site_should_trim_menu(): void
    {
        // Get a menu
        $menu = app(Menu::class)->withChildItems()->create(5);

        // Set the page id
        $page_id = reset(reset($menu)['submenu'])['page_id'];

        // Get the site menu
        $site_menu = app(MenuRepository::class)->getSiteMenu($menu, $page_id);

        // Trim the site menu
        $trimmed = app(MenuRepository::class)->trimSiteMenu($site_menu);

        // Make sure trimmed menu is the same as the one we selected
        $this->assertEquals(reset($site_menu['menu'])['submenu'], $trimmed['menu']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::trimSiteMenu
     * @test
     */
    public function trimming_site_menu_while_parent_id_is_passed_should_trim_menu(): void
    {
        // Get a menu
        $menu = app(\Factories\Menu::class)->withChildItems()->create(5);

        // Set the page id
        $page_id = reset(reset($menu)['submenu'])['page_id'];

        // Get the site menu
        $site_menu = app(MenuRepository::class)->getSiteMenu($menu, $page_id);

        // Only passing parent id should trim menu
        $trimmed = app(MenuRepository::class)->trimSiteMenu($site_menu, $this->faker->numberBetween(1, 10));

        // Make sure the menu is trimmed
        $this->assertEquals(reset($site_menu['menu'])['submenu'], $trimmed['menu']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::trimSiteMenu
     * @test
     */
    public function trimming_site_menu_while_top_menu_id_is_passed_should_trim_menu(): void
    {
        // Get a menu
        $menu = app(Menu::class)->withChildItems()->create(5);

        // Set the page id
        $page_id = reset(reset($menu)['submenu'])['page_id'];

        // Get the site menu
        $site_menu = app(MenuRepository::class)->getSiteMenu($menu, $page_id);

        // Only passing top menu id should trim menu
        $trimmed = app(MenuRepository::class)->trimSiteMenu($site_menu, null, $this->faker->numberBetween(1, 10));

        // Make sure the menu is trimmed
        $this->assertEquals(reset($site_menu['menu'])['submenu'], $trimmed['menu']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::trimSiteMenu
     * @test
     */
    public function trimming_site_menu_while_top_menu_id_and_parent_id_is_passed_should_not_trim_menu(): void
    {
        // Get a menu
        $menu = app(Menu::class)->withChildItems()->create(5);

        // Set the page id
        $page_id = reset(reset($menu)['submenu'])['page_id'];

        // Get the site menu
        $site_menu = app(MenuRepository::class)->getSiteMenu($menu, $page_id);

        // Get the trimmed menu based on parent and top menu id being passed
        $trimmed = app(MenuRepository::class)->trimSiteMenu($site_menu, $this->faker->numberBetween(1, 10), $this->faker->numberBetween(1, 10));

        // Make sure the menu is not trimmed
        $this->assertEquals($site_menu, $trimmed);
    }

    /**
     * @covers \App\Repositories\MenuRepository::trimSiteMenu
     * @test
     */
    public function trimming_site_menu_while_top_menu_is_selected_with_no_children_should_reset_selected_state(): void
    {
        // Get a menu
        $menu = app(Menu::class)->create(5);

        // Set the page id
        $page_id = null;

        // Get the site menu
        $site_menu = app(MenuRepository::class)->getSiteMenu($menu, $page_id);

        // Get the trimmed menu
        $trimmed = app(MenuRepository::class)->trimSiteMenu($site_menu);

        // Make sure the trimmed selected state isn't selected
        $this->assertFalse($trimmed['meta']['has_selected']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getTopMenu
     * @test
     */
    public function getting_top_menu_selected_states(): void
    {
        // Get a menu
        $menu = app(Menu::class)->create(5);

        // Set the page id
        $page_id = reset($menu)['page_id'];

        // Get the top menu with valid page id
        $top_menu = app(MenuRepository::class)->getTopMenu($menu, $page_id);

        // Make sure we have a selected state
        $this->assertCount(count($menu), $top_menu['menu']);
        $this->assertTrue($top_menu['meta']['has_selected']);
        $this->assertTrue($top_menu['menu'][$page_id]['is_selected']);

        // Get the top menu when a page id that is passed in does not exist
        $top_menu = app(MenuRepository::class)->getTopMenu($menu, $this->faker->numberBetween(5000, 10000));

        // Make sure we don't have a selected state
        $this->assertCount(count($menu), $top_menu['menu']);
        $this->assertFalse($top_menu['meta']['has_selected']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getTopMenu
     * @test
     */
    public function top_menu_should_be_one_level_deep(): void
    {
        // Get a menu
        $menu = app(Menu::class)->withChildItems()->create(5);

        // Set the page id
        $page_id = reset($menu)['page_id'];

        // Get the top menu
        $top_menu = app(MenuRepository::class)->getTopMenu($menu, $page_id);

        // Make sure we don't have sub items
        $this->assertCount(0, $top_menu['menu'][$page_id]['submenu']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getTopMenuId
     * @test
     */
    public function setting_top_menu_id_should_return_correct_top_menu(): void
    {
        // Make the repository
        $menuRepository = app(MenuRepository::class);

        // Set random ids
        $random_menu_id = $this->faker->numberBetween(1, 50);
        $random_top_menu_id = $this->faker->numberBetween(51, 100);

        // Set only the menu_id
        $this->assertEquals($random_menu_id, $menuRepository->getTopMenuId($random_menu_id, null, [$random_menu_id => []]));

        // Set a top menu id override
        $this->assertEquals($random_top_menu_id, $menuRepository->getTopMenuId($random_menu_id, $random_top_menu_id, [$random_top_menu_id => ['menu']]));

        // Passing a top_menu_id that does not exist in the menus array should return the regular menu_id
        $this->assertEquals($random_menu_id, $menuRepository->getTopMenuId($random_menu_id, $random_top_menu_id, []));

        // Not passing a menu_id should return top menu id
        $this->assertEquals($random_top_menu_id, $menuRepository->getTopMenuId(null, $random_top_menu_id, [$random_top_menu_id => ['menu']]));

        // No params should return null
        $this->assertEquals(null, $menuRepository->getTopMenuId());
    }

    /**
     * @covers \App\Repositories\MenuRepository::getBreadcrumbs
     * @test
     */
    public function getting_breadcrumbs_with_subsite_should_add_subsite_homepage(): void
    {
        // Get a menu
        $menu = app(Menu::class)->withChildItems()->create(5);

        // Set the page id
        $page_id = reset(reset($menu)['submenu'])['page_id'];

        // Get the site menu
        $site_menu = app(MenuRepository::class)->getSiteMenu($menu, $page_id);

        // Combine 2 fake words to create a very unique word
        $folder = $this->faker->word().$this->faker->word().'/';
        $site_title = $this->faker->sentence();

        // Get the breadcrumbs
        $breadcrumbs = app(MenuRepository::class)->getBreadcrumbs($site_menu, $site_title, $folder);

        // Make sure the first second item in the random folder
        $this->assertEquals('/'.rtrim($folder, '/'), $breadcrumbs[1]['relative_url']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getBreadcrumbs
     * @test
     */
    public function getting_breadcrumbs_if_in_menu_should_not_add_subsite_homepage(): void
    {
        // Get a menu
        $menu = app(Menu::class)->withChildItems()->create(5);

        // Set the page id
        $page_id = reset(reset($menu)['submenu'])['page_id'];

        // Get the site menu
        $site_menu = app(MenuRepository::class)->getSiteMenu($menu, $page_id);

        // Create the subsite folder "name/" from the relative url of the item we are comparing to
        $folder = ltrim(reset($menu)['relative_url'], '/').'/';

        // Get the breadcrumbs
        $breadcrumbs = app(MenuRepository::class)->getBreadcrumbs($site_menu, $this->faker->sentence(), $folder);

        // Make sure the first second item are not the same, subsite root already exists
        $this->assertNotEquals($breadcrumbs[1]['relative_url'], $breadcrumbs[2]['relative_url']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getBreadcrumbs
     * @test
     */
    public function getting_breadcrumbs_should_return_all_breadcrumbs(): void
    {
        // Get a menu
        $menu = app(Menu::class)->withChildItems()->create(5);

        // Set the page id
        $page_id = reset(reset($menu)['submenu'])['page_id'];

        // Set the parent page_id
        $parent_id = reset($menu)['page_id'];

        // Get the site menu
        $site_menu = app(MenuRepository::class)->getSiteMenu($menu, $page_id);

        // Get the breadcrumbs
        $breadcrumbs = app(MenuRepository::class)->getBreadcrumbs($site_menu);

        // Make sure home was prepended
        $this->assertEquals('Home', $breadcrumbs[0]['display_name']);

        // Make sure both breadcrumbs exist
        $this->assertEquals($parent_id, $breadcrumbs[1]['page_id']);
        $this->assertEquals($page_id, $breadcrumbs[2]['page_id']);

        // Make sure we have the proper amount of breadcrumbs
        $this->assertCount(3, $breadcrumbs);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getBreadcrumbs
     * @test
     */
    public function getting_breadcrumbs_with_no_path_should_return_nothing(): void
    {
        // Get a menu
        $menu = app(Menu::class)->withChildItems()->create(5);

        // Get the site menu
        $site_menu = app(MenuRepository::class)->getSiteMenu($menu);

        // Get the breadcrumbs
        $breadcrumbs = app(MenuRepository::class)->getBreadcrumbs($site_menu);

        // Make sure we don't have any breadcrumbs
        $this->assertCount(0, $breadcrumbs);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getMenus
     * @test
     */
    public function homepage_menu_is_disabled_when_config_is_disabled(): void
    {
        // Get the current config for if the menu is enabled or not
        $currentConfig = config('base.homepage_menu_enabled');

        // Disable the menu on the homepage
        config(['base.homepage_menu_enabled' => false]);

        // Get a page with the HomepageController set
        $page = app(Page::class)->create(
            1,
            true,
            [
                'page' => [
                    'controller' => 'HomepageController',
                ],
            ]
        );

        // Get a menu and mimic as if there were multiple
        $menu[$page['menu']['id']] = app(Menu::class)->create(5);

        // Get all the menus
        $menus = app(MenuRepository::class)->getMenus($page, $menu);

        $this->assertFalse($menus['show_site_menu']);

        // Set it back to what it was
        config(['base.top_menu_enabled' => $currentConfig]);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getRequestData
     * @test
     */
    public function getting_all_menus_should_return_array_of_menus(): void
    {
        // Get a page with the HomepageController set
        $page = app(Page::class)->create(
            1,
            true,
            [
                'page' => [
                    'controller' => 'HomepageController',
                ],
            ]
        );

        // Mock the Connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.menuitems.listing', Mockery::type('array'))->once()->andReturn([]);

        // Get all the menus
        $menus = app(MenuRepository::class, ['wsuApi' => $wsuApi])->getRequestData($page);

        // Make sure no menu output exists
        $this->assertEquals('', $menus['site_menu_output']);
        $this->assertEquals('', $menus['top_menu_output']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getSiteMenuOutput
     * @test
     */
    public function getting_site_menu_output_should_return_site_menu(): void
    {
        // Get a menu
        $menu = app(Menu::class)->create(5);

        // Parse the site menu
        $siteMenu = app(MenuRepository::class)->getSiteMenu($menu);

        // Get the output
        $output = app(MenuRepository::class)->getSiteMenuOutput($siteMenu['menu']);

        // Make sure we have a starting menu
        $this->assertMatchesRegularExpression('/<ul/', $output);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getTopMenuOutput
     * @test
     */
    public function getting_top_menu_output_should_return_top_menu(): void
    {
        // Get a menu
        $menu = app(Menu::class)->create(5);

        // Parse the site menu
        $topMenu = app(MenuRepository::class)->getTopMenu($menu);

        // Get the output
        $output = app(MenuRepository::class)->getTopMenuOutput($topMenu['menu']);

        // Make sure we have a starting menu
        $this->assertMatchesRegularExpression('/<ul/', $output);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getMenus
     * @test
     */
    public function page_with_no_menu_should_hide_the_site_menu(): void
    {
        // Get a page with the HomepageController set
        $page = app(Page::class)->create(
            1,
            true,
            [
                'page' => [
                    'controller' => 'HomepageController',
                ],
                'menu' => [
                    'id' => null,
                ],
            ]
        );

        // Parse the site menu
        $menu = app(MenuRepository::class)->getMenus($page, []);

        $this->assertFalse($menu['show_site_menu']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getMenus
     * @test
     */
    public function page_with_menu_and_no_submenu_items_with_top_menu_enabled_showsitemenu_should_be_false(): void
    {
        // Force enable top menu
        config(['base.top_menu_enabled' => true]);

        // Get a page with the HomepageController set
        $page = app(Page::class)->create(
            1,
            true,
            [
                'page' => [
                    'controller' => 'ChildpageController',
                ],
                'menu' => [
                    'id' => 1,
                ],
            ]
        );
        // Get a menu and mimic as if there were multiple
        $menu[$page['menu']['id']] = app(Menu::class)->create(5);

        // Parse the site menu
        $menus = app(MenuRepository::class)->getMenus($page, $menu);

        $this->assertFalse($menus['show_site_menu']);
    }

    /**
     * @covers \App\Repositories\MenuRepository::getMenus
     * @test
     */
    public function page_should_show_full_width_hero_with_no_site_menu(): void
    {
        // Create a fake data request
        $page = app(Page::class)->create(
            1,
            true,
            [
                'page' => [
                    'controller' => 'ExampleController',
                ],
                'menu' => [
                    'id' => 1,
                ],
            ]
        );

        // Fake a site menu with no menu
        $menu[$page['menu']['id']] = [];

        // Parse the site menu
        app(MenuRepository::class)->getMenus($page, $menu);

        $this->assertTrue(in_array('ExampleController', config('base.hero_full_controllers')));
    }

    /**
     * @covers \App\Repositories\MenuRepository::getMenus
     * @test
     */
    public function page_should_show_full_width_hero_with_site_menu_but_menu_is_hidden(): void
    {
        // Create a fake data request
        $page = app(Page::class)->create(
            1,
            true,
            [
                'page' => [
                    'controller' => 'HomepageController',
                ],
                'menu' => [
                    'id' => 1,
                ],
            ]
        );

        // Set default config values
        config(['base.hero_full_controllers' => []]);
        config(['base.homepage_menu_enabled' => false]);

        // Fake a site menu
        $menu[$page['menu']['id']] = app(Menu::class)->create(5);

        // Parse the site menu
        app(MenuRepository::class)->getMenus($page, $menu);

        $this->assertTrue(in_array('HomepageController', config('base.hero_full_controllers')));
    }
}
