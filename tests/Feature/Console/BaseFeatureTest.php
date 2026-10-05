<?php

namespace Tests\Feature\Console;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

final class BaseFeatureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeBaseDisk();

        $this->artisan('base:feature', ['feature' => 'FacultyBook'])->assertSuccessful();
    }

    #[Test]
    public function controller_should_be_a_site_controller(): void
    {
        $controller = Storage::disk('base')->get('app/Http/Controllers/Custom/FacultyBookController.php');

        $this->assertStringContainsString('namespace App\Http\Controllers\Custom;', $controller);
        $this->assertStringContainsString('use App\Http\Controllers\Controller;', $controller);
        $this->assertStringContainsString('use Contracts\Repositories\Custom\FacultyBookRepositoryContract;', $controller);
        $this->assertStringContainsString("view('site-specific.faculty-book'", $controller);
        $this->assertFalse(Storage::disk('base')->exists('app/Http/Controllers/FacultyBookController.php'));
    }

    #[Test]
    public function contract_and_repositories_should_be_site_classes(): void
    {
        $disk = Storage::disk('base');

        $this->assertStringContainsString('namespace Contracts\Repositories\Custom;', $disk->get('contracts/Repositories/Custom/FacultyBookRepositoryContract.php'));

        $repository = $disk->get('app/Repositories/Custom/FacultyBookRepository.php');
        $this->assertStringContainsString('namespace App\Repositories\Custom;', $repository);
        $this->assertStringContainsString('use Contracts\Repositories\Custom\FacultyBookRepositoryContract;', $repository);

        $styleguide = $disk->get('styleguide/Repositories/Custom/FacultyBookRepository.php');
        $this->assertStringContainsString('namespace Styleguide\Repositories\Custom;', $styleguide);
        $this->assertStringContainsString('use App\Repositories\Custom\FacultyBookRepository as Repository;', $styleguide);
        $this->assertStringContainsString('use Factories\Custom\FacultyBook;', $styleguide);
    }

    #[Test]
    public function factory_and_view_should_be_site_specific(): void
    {
        $this->assertStringContainsString('namespace Factories\Custom;', Storage::disk('base')->get('factories/Custom/FacultyBook.php'));
        $this->assertTrue(Storage::disk('base')->exists('resources/views/site-specific/faculty-book.blade.php'));
    }

    #[Test]
    public function styleguide_page_should_be_a_custom_page_under_site_specific(): void
    {
        $page = Storage::disk('base')->get('styleguide/Pages/Custom/FacultyBook.php');
        $this->assertStringContainsString('namespace Styleguide\Pages\Custom;', $page);
        $this->assertStringContainsString('use Styleguide\Pages\Page;', $page);
        $this->assertStringContainsString('class FacultyBook extends Page', $page);
        $this->assertStringContainsString("'controller' => 'FacultyBookController'", $page);
        $this->assertFalse(Storage::disk('base')->exists('styleguide/Pages/SitespecificFacultyBook.php'));

        $menu = json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
        $item = end($menu[101]['submenu'][999]['submenu']);
        $this->assertSame('FacultyBook', $item['display_name']);
        $this->assertSame('/styleguide/facultybook', $item['relative_url']);
    }

    #[Test]
    public function menu_item_id_should_not_collide_with_another_menu_item(): void
    {
        $menu = json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
        $new = end($menu[101]['submenu'][999]['submenu'])['menu_item_id'];

        $ids = [];
        array_walk_recursive($menu, function ($value, $key) use (&$ids) {
            if (in_array($key, ['menu_item_id', 'page_id'], true)) {
                $ids[] = $value;
            }
        });

        // Once as menu_item_id, once as page_id
        $this->assertCount(2, array_keys($ids, $new, true));
    }

    #[Test]
    public function base_option_should_scaffold_into_base_folders(): void
    {
        $this->artisan('base:feature', ['feature' => 'Award', '--base' => true])->assertSuccessful();

        $disk = Storage::disk('base');

        $controller = $disk->get('app/Http/Controllers/AwardController.php');
        $this->assertStringContainsString('namespace App\Http\Controllers;', $controller);
        $this->assertStringNotContainsString('use App\Http\Controllers\Controller;', $controller);
        $this->assertStringContainsString('use Contracts\Repositories\AwardRepositoryContract;', $controller);
        $this->assertStringContainsString("view('award'", $controller);

        $this->assertStringContainsString('namespace Contracts\Repositories;', $disk->get('contracts/Repositories/AwardRepositoryContract.php'));
        $this->assertStringContainsString('namespace App\Repositories;', $disk->get('app/Repositories/AwardRepository.php'));
        $this->assertStringContainsString('use Factories\Award;', $disk->get('styleguide/Repositories/AwardRepository.php'));
        $this->assertStringContainsString('namespace Factories;', $disk->get('factories/Award.php'));
        $this->assertTrue($disk->exists('resources/views/award.blade.php'));
        $page = $disk->get('styleguide/Pages/Award.php');
        $this->assertStringContainsString('namespace Styleguide\Pages;', $page);
        $this->assertStringNotContainsString('use Styleguide\Pages\Page;', $page);
        $this->assertStringContainsString('class Award extends Page', $page);
        $this->assertFalse($disk->exists('app/Http/Controllers/Custom/AwardController.php'));
    }

    #[Test]
    public function base_option_should_add_the_page_to_templates_before_site_specific(): void
    {
        $this->artisan('base:feature', ['feature' => 'Award', '--base' => true])->assertSuccessful();

        $templates = json_decode(Storage::disk('base')->get('styleguide/menu.json'), true)[101]['submenu'];
        $keys = array_keys($templates);
        $award = array_search('Award', array_column($templates, 'display_name'), true);

        $this->assertSame('/styleguide/award', $templates[$keys[$award]]['relative_url']);
        $this->assertSame(999, $keys[$award + 1]);
    }

    #[Test]
    public function existing_feature_should_not_be_overwritten(): void
    {
        $this->artisan('base:feature', ['feature' => 'FacultyBook'])->assertFailed();
    }

    #[Test]
    public function feature_named_after_a_base_controller_should_fail(): void
    {
        Storage::disk('base')->put('app/Http/Controllers/ArticleController.php', '');

        $this->artisan('base:feature', ['feature' => 'Article'])->assertFailed();
        $this->assertFalse(Storage::disk('base')->exists('app/Http/Controllers/Custom/ArticleController.php'));
    }

    #[Test]
    public function feature_named_after_a_base_styleguide_page_should_fail(): void
    {
        Storage::disk('base')->put('styleguide/Pages/Directory.php', '');

        $this->artisan('base:feature', ['feature' => 'Directory'])->assertFailed();
        $this->assertFalse(Storage::disk('base')->exists('styleguide/Pages/Custom/Directory.php'));
    }
}
