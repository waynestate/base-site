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
    }

    #[Test]
    public function default_should_scaffold_into_base_folders(): void
    {
        $this->artisan('base:feature', ['feature' => 'Award'])->assertSuccessful();

        $disk = Storage::disk('base');

        $controller = $disk->get('app/Http/Controllers/AwardController.php');
        $this->assertStringContainsString('namespace App\Http\Controllers;', $controller);
        $this->assertStringContainsString('use Contracts\Repositories\AwardRepositoryContract;', $controller);

        $this->assertStringContainsString('namespace Contracts\Repositories;', $disk->get('contracts/Repositories/AwardRepositoryContract.php'));
        $this->assertStringContainsString('namespace App\Repositories;', $disk->get('app/Repositories/AwardRepository.php'));
        $this->assertStringContainsString('use Factories\Award;', $disk->get('styleguide/Repositories/AwardRepository.php'));
        $this->assertStringContainsString('namespace Factories;', $disk->get('factories/Award.php'));
        $this->assertTrue($disk->exists('resources/views/award.blade.php'));
        $this->assertStringContainsString('class Award extends Page', $disk->get('styleguide/Pages/Award.php'));

        $menu = json_decode($disk->get('styleguide/menu.json'), true);
        $item = end($menu[101]['submenu'][999]['submenu']);
        $this->assertSame('Award', $item['display_name']);
    }

    #[Test]
    public function site_option_should_scaffold_into_configured_site_namespace(): void
    {
        config(['base.site_namespace' => 'Nursing']);

        $this->artisan('base:feature', ['feature' => 'FacultyBook', '--site' => true])->assertSuccessful();

        $disk = Storage::disk('base');

        $controller = $disk->get('app/Nursing/Controllers/FacultyBookController.php');
        $this->assertStringContainsString('namespace App\Nursing\Controllers;', $controller);
        $this->assertStringContainsString('use Contracts\Repositories\FacultyBookRepositoryContract;', $controller);
        $this->assertFalse($disk->exists('app/Http/Controllers/FacultyBookController.php'));

        $this->assertStringContainsString('namespace Contracts\Repositories;', $disk->get('contracts/Repositories/FacultyBookRepositoryContract.php'));

        $repository = $disk->get('app/Nursing/Repositories/FacultyBookRepository.php');
        $this->assertStringContainsString('namespace App\Nursing\Repositories;', $repository);

        $styleguide = $disk->get('app/Nursing/Styleguide/Repositories/FacultyBookRepository.php');
        $this->assertStringContainsString('namespace App\Nursing\Styleguide\Repositories;', $styleguide);
        $this->assertStringContainsString('use App\Nursing\Repositories\FacultyBookRepository as Repository;', $styleguide);

        $this->assertTrue($disk->exists('resources/views/nursing/faculty-book.blade.php'));
        $this->assertFalse($disk->exists('resources/views/faculty-book.blade.php'));

        $page = $disk->get('app/Nursing/Styleguide/Pages/FacultyBook.php');
        $this->assertStringContainsString('namespace App\Nursing\Styleguide\Pages;', $page);
        $this->assertStringContainsString("'controller' => 'FacultyBookController'", $page);

        // Site menu should be created with only partial additions in the reserved range (999101+)
        $this->assertTrue($disk->exists('app/Nursing/Styleguide/menu.json'));
        $siteMenu = json_decode($disk->get('app/Nursing/Styleguide/menu.json'), true);
        $this->assertArrayNotHasKey(100, $siteMenu);
        $this->assertArrayNotHasKey(102, $siteMenu);
        $this->assertArrayNotHasKey(103, $siteMenu);

        $item = end($siteMenu[101]['submenu'][999]['submenu']);
        $this->assertSame('FacultyBook', $item['display_name']);
        $this->assertSame(999101, $item['menu_item_id']);
        $this->assertSame(999101, $item['page_id']);
        $this->assertStringContainsString("'id' => 999101", $page);

        // A second feature should increment to the next ID in the reserved range
        $this->artisan('base:feature', ['feature' => 'FacultyAward', '--site' => true])->assertSuccessful();
        $updatedSiteMenu = json_decode($disk->get('app/Nursing/Styleguide/menu.json'), true);
        $secondItem = end($updatedSiteMenu[101]['submenu'][999]['submenu']);
        $this->assertSame('FacultyAward', $secondItem['display_name']);
        $this->assertSame(999102, $secondItem['menu_item_id']);
        $this->assertSame(999102, $secondItem['page_id']);

        $secondPage = $disk->get('app/Nursing/Styleguide/Pages/FacultyAward.php');
        $this->assertStringContainsString("'id' => 999102", $secondPage);
    }

    #[Test]
    public function site_option_with_explicit_value_should_scaffold_into_specified_namespace(): void
    {
        $this->artisan('base:feature', ['feature' => 'ResearchGrant', '--site' => 'SocialWork'])->assertSuccessful();

        $disk = Storage::disk('base');

        $this->assertTrue($disk->exists('app/SocialWork/Controllers/ResearchGrantController.php'));
        $this->assertTrue($disk->exists('resources/views/social_work/research-grant.blade.php'));
        $this->assertTrue($disk->exists('app/SocialWork/Styleguide/Pages/ResearchGrant.php'));
    }

    #[Test]
    public function existing_feature_should_not_be_overwritten(): void
    {
        $this->artisan('base:feature', ['feature' => 'FacultyBook'])->assertSuccessful();
        $this->artisan('base:feature', ['feature' => 'FacultyBook'])->assertFailed();
    }

    #[Test]
    public function existing_factory_should_not_be_overwritten(): void
    {
        $disk = Storage::disk('base');
        $disk->put('factories/CustomFeature.php', 'original-content');

        $this->artisan('base:feature', ['feature' => 'CustomFeature'])->assertSuccessful();

        $this->assertSame('original-content', $disk->get('factories/CustomFeature.php'));
    }
}
