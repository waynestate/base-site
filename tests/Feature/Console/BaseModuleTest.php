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

        $this->artisan('base:module', ['name' => 'expanding-grid'])->assertSuccessful();
    }

    #[Test]
    public function component_should_be_site_specific(): void
    {
        $this->assertTrue(Storage::disk('base')->exists('resources/views/site-specific/components/expanding-grid.blade.php'));
        $this->assertFalse(Storage::disk('base')->exists('resources/views/components/expanding-grid.blade.php'));
    }

    #[Test]
    public function styleguide_controller_should_be_a_site_controller(): void
    {
        $controller = Storage::disk('base')->get('styleguide/Http/Controllers/Custom/ComponentExpandingGridController.php');

        $this->assertStringContainsString('namespace Styleguide\Http\Controllers\Custom;', $controller);
        $this->assertStringContainsString('class ComponentExpandingGridController extends Controller', $controller);
        $this->assertStringContainsString("'filename' => 'expanding-grid'", $controller);
    }

    #[Test]
    public function styleguide_page_should_be_under_site_specific(): void
    {
        $page = Storage::disk('base')->get('styleguide/Pages/ComponentSitespecificExpandingGrid.php');
        $this->assertStringContainsString('class ComponentSitespecificExpandingGrid extends Page', $page);
        $this->assertStringContainsString("'controller' => 'ComponentExpandingGridController'", $page);

        $menu = json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
        $item = end($menu[102]['submenu'][9999]['submenu']);
        $this->assertSame('Expanding Grid', $item['display_name']);
        $this->assertSame('/styleguide/component/sitespecific/expandinggrid', $item['relative_url']);
    }

    #[Test]
    public function base_option_should_scaffold_into_base_folders(): void
    {
        $this->artisan('base:module', ['name' => 'photo-strip', '--base' => true])->assertSuccessful();

        $disk = Storage::disk('base');

        $this->assertTrue($disk->exists('resources/views/components/photo-strip.blade.php'));
        $this->assertStringContainsString('namespace Styleguide\Http\Controllers;', $disk->get('styleguide/Http/Controllers/ComponentPhotoStripController.php'));
        $this->assertStringContainsString('class ComponentPhotoStrip extends Page', $disk->get('styleguide/Pages/ComponentPhotoStrip.php'));

        $components = json_decode($disk->get('styleguide/menu.json'), true)[102]['submenu'];
        $keys = array_keys($components);
        $strip = array_search('Photo Strip', array_column($components, 'display_name'), true);

        $this->assertSame('/styleguide/component/photostrip', $components[$keys[$strip]]['relative_url']);
        $this->assertSame(9999, $keys[$strip + 1]);
    }

    #[Test]
    public function existing_module_should_not_be_overwritten(): void
    {
        $this->artisan('base:module', ['name' => 'expanding-grid'])->assertFailed();
    }

    #[Test]
    public function module_named_after_a_base_component_should_fail(): void
    {
        Storage::disk('base')->put('resources/views/components/accordion.blade.php', '');

        $this->artisan('base:module', ['name' => 'accordion'])->assertFailed();
        $this->assertFalse(Storage::disk('base')->exists('resources/views/site-specific/components/accordion.blade.php'));
    }
}
