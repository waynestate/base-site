<?php

namespace Tests\Feature\Console;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

final class BaseModuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeBaseDisk();
    }

    #[Test]
    public function default_should_scaffold_into_base_folders(): void
    {
        $this->artisan('base:module', ['name' => 'expanding-grid'])->assertSuccessful();

        $disk = Storage::disk('base');

        $this->assertTrue($disk->exists('resources/views/components/expanding-grid.blade.php'));
        $this->assertTrue($disk->exists('styleguide/Http/Controllers/ComponentExpandingGridController.php'));
        $this->assertTrue($disk->exists('styleguide/Pages/ComponentExpandingGrid.php'));

        $menu = json_decode($disk->get('styleguide/menu.json'), true);
        $item = end($menu[102]['submenu'][9999]['submenu']);
        $this->assertSame('Expanding Grid', $item['display_name']);
    }

    #[Test]
    public function site_option_should_scaffold_into_configured_site_namespace(): void
    {
        config(['base.site_namespace' => 'Nursing']);

        $this->artisan('base:module', ['name' => 'expanding-grid', '--site' => true])->assertSuccessful();

        $disk = Storage::disk('base');

        $this->assertTrue($disk->exists('resources/views/nursing/components/expanding-grid.blade.php'));
        $this->assertFalse($disk->exists('resources/views/components/expanding-grid.blade.php'));

        $controller = $disk->get('app/Nursing/Styleguide/Controllers/ComponentExpandingGridController.php');
        $this->assertStringContainsString('namespace App\Nursing\Styleguide\Controllers;', $controller);
        $this->assertSame(1, substr_count($controller, 'use App\Http\Controllers\Controller;'));

        $page = $disk->get('app/Nursing/Styleguide/Pages/ComponentExpandingGrid.php');
        $this->assertStringContainsString('namespace App\Nursing\Styleguide\Pages;', $page);

        // Site menu should be created with only partial additions in the reserved range (999901+)
        $this->assertTrue($disk->exists('app/Nursing/Styleguide/menu.json'));
        $siteMenu = json_decode($disk->get('app/Nursing/Styleguide/menu.json'), true);
        $this->assertArrayNotHasKey(100, $siteMenu);
        $this->assertArrayNotHasKey(101, $siteMenu);
        $this->assertArrayNotHasKey(103, $siteMenu);

        $item = end($siteMenu[102]['submenu'][9999]['submenu']);
        $this->assertSame('Expanding Grid', $item['display_name']);
        $this->assertSame(999901, $item['menu_item_id']);
        $this->assertSame(999901, $item['page_id']);
        $this->assertStringContainsString("'id' => 999901", $page);

        // A second module should increment to the next ID in the reserved range
        $this->artisan('base:module', ['name' => 'hero-slider', '--site' => true])->assertSuccessful();
        $updatedSiteMenu = json_decode($disk->get('app/Nursing/Styleguide/menu.json'), true);
        $secondItem = end($updatedSiteMenu[102]['submenu'][9999]['submenu']);
        $this->assertSame('Hero Slider', $secondItem['display_name']);
        $this->assertSame(999902, $secondItem['menu_item_id']);
        $this->assertSame(999902, $secondItem['page_id']);

        $secondPage = $disk->get('app/Nursing/Styleguide/Pages/ComponentHeroSlider.php');
        $this->assertStringContainsString("'id' => 999902", $secondPage);
    }

    #[Test]
    public function existing_module_should_not_be_overwritten(): void
    {
        $this->artisan('base:module', ['name' => 'expanding-grid'])->assertSuccessful();
        $this->artisan('base:module', ['name' => 'expanding-grid'])->assertFailed();
    }
}
