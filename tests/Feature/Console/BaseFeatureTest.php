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
    public function classes_should_be_scaffolded_outside_custom(): void
    {
        $disk = Storage::disk('base');

        $controller = $disk->get('app/Http/Controllers/FacultyBookController.php');
        $this->assertStringContainsString('namespace App\Http\Controllers;', $controller);
        $this->assertStringNotContainsString('use App\Http\Controllers\Controller;', $controller);
        $this->assertStringContainsString('use Contracts\Repositories\FacultyBookRepositoryContract;', $controller);

        $this->assertStringContainsString('namespace Contracts\Repositories;', $disk->get('contracts/Repositories/FacultyBookRepositoryContract.php'));

        $repository = $disk->get('app/Repositories/FacultyBookRepository.php');
        $this->assertStringContainsString('namespace App\Repositories;', $repository);
        $this->assertStringContainsString('use Contracts\Repositories\FacultyBookRepositoryContract;', $repository);

        $styleguide = $disk->get('styleguide/Repositories/FacultyBookRepository.php');
        $this->assertStringContainsString('namespace Styleguide\Repositories;', $styleguide);
        $this->assertStringContainsString('use App\Repositories\FacultyBookRepository as Repository;', $styleguide);
        $this->assertStringContainsString('use Factories\FacultyBook;', $styleguide);

        $this->assertStringContainsString('namespace Factories;', $disk->get('factories/FacultyBook.php'));

        $this->assertSame([], $disk->allFiles('app/Http/Controllers/Custom'));
        $this->assertSame([], $disk->allFiles('styleguide/Pages/Custom'));
    }

    #[Test]
    public function view_should_be_site_specific(): void
    {
        $this->assertStringContainsString("view('site-specific.faculty-book'", Storage::disk('base')->get('app/Http/Controllers/FacultyBookController.php'));
        $this->assertTrue(Storage::disk('base')->exists('resources/views/site-specific/faculty-book.blade.php'));
    }

    #[Test]
    public function styleguide_page_should_be_listed_under_site_specific(): void
    {
        $page = Storage::disk('base')->get('styleguide/Pages/FacultyBook.php');
        $this->assertStringContainsString('namespace Styleguide\Pages;', $page);
        $this->assertStringNotContainsString('use Styleguide\Pages\Page;', $page);
        $this->assertStringContainsString('class FacultyBook extends Page', $page);
        $this->assertStringContainsString("'controller' => 'FacultyBookController'", $page);

        $this->assertSame('/styleguide/facultybook', $this->siteSpecificItem('FacultyBook')['relative_url']);
    }

    #[Test]
    public function menu_item_id_should_not_collide_with_another_menu_item(): void
    {
        $menu = json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
        $new = $this->siteSpecificItem('FacultyBook')['menu_item_id'];

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
    public function site_specific_pages_should_be_added_alphabetically_after_the_guide(): void
    {
        $menu = json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
        $menu[101]['submenu'][999]['submenu'] = [
            99901 => ['menu_item_id' => 99901, 'page_id' => 99901, 'display_name' => 'Create site specific templates'],
            99902 => ['menu_item_id' => 99902, 'page_id' => 99902, 'display_name' => 'Degree'],
            99903 => ['menu_item_id' => 99903, 'page_id' => 99903, 'display_name' => 'Students'],
        ];
        Storage::disk('base')->put('styleguide/menu.json', json_encode($menu));

        $this->artisan('base:feature', ['feature' => 'Program'])->assertSuccessful();
        $this->artisan('base:feature', ['feature' => 'Award'])->assertSuccessful();
        $this->artisan('base:feature', ['feature' => 'Spotlight'])->assertSuccessful();

        $menu = json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
        $this->assertSame(
            ['Create site specific templates', 'Award', 'Degree', 'Program', 'Spotlight', 'Students'],
            array_column($menu[101]['submenu'][999]['submenu'], 'display_name')
        );
    }

    #[Test]
    public function base_option_should_put_the_view_outside_site_specific(): void
    {
        $this->artisan('base:feature', ['feature' => 'Award', '--base' => true])->assertSuccessful();

        $this->assertStringContainsString("view('award'", Storage::disk('base')->get('app/Http/Controllers/AwardController.php'));
        $this->assertTrue(Storage::disk('base')->exists('resources/views/award.blade.php'));
        $this->assertFalse(Storage::disk('base')->exists('resources/views/site-specific/award.blade.php'));
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
        $this->assertSame('', Storage::disk('base')->get('app/Http/Controllers/ArticleController.php'));
    }

    #[Test]
    public function feature_named_after_a_base_styleguide_page_should_fail(): void
    {
        Storage::disk('base')->put('styleguide/Pages/Directory.php', '');

        $this->artisan('base:feature', ['feature' => 'Directory'])->assertFailed();
        $this->assertSame('', Storage::disk('base')->get('styleguide/Pages/Directory.php'));
    }

    #[Test]
    public function feature_named_after_a_base_styleguide_page_in_another_case_should_fail(): void
    {
        Storage::disk('base')->put('styleguide/Pages/NewsTopics.php', '');

        $this->artisan('base:feature', ['feature' => 'Newstopics'])->assertFailed();
        $this->assertSame('', Storage::disk('base')->get('styleguide/Pages/NewsTopics.php'));
    }

    #[Test]
    public function feature_named_after_a_custom_overload_should_fail(): void
    {
        Storage::disk('base')->put('app/Http/Controllers/Custom/AwardController.php', 'hand-written');

        $this->artisan('base:feature', ['feature' => 'Award'])->assertFailed();
        $this->assertFalse(Storage::disk('base')->exists('app/Http/Controllers/AwardController.php'));
    }

    /**
     * Get a Site specific menu item by its display name.
     */
    private function siteSpecificItem(string $name): array
    {
        $menu = json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);

        return collect($menu[101]['submenu'][999]['submenu'])->firstWhere('display_name', $name);
    }
}
