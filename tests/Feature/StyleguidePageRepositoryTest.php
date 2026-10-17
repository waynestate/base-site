<?php

namespace Tests\Feature;

use Contracts\Pages\StyleguidePageContract;
use Illuminate\Support\Facades\Storage;
use Mockery as Mockery;
use PHPUnit\Framework\Attributes\Test;
use Styleguide\Repositories\PageRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

final class StyleguidePageRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('base');
    }

    #[Test]
    public function custom_page_should_override_the_base_page(): void
    {
        $this->page('Styleguide\Pages\Zzsample', 'Base');
        $this->page('Styleguide\Pages\Custom\Zzsample', 'Custom');

        $this->assertSame('Custom', $this->getPageData('styleguide/zzsample')['title']);
    }

    #[Test]
    public function base_page_should_load_without_a_custom_folder(): void
    {
        $this->page('Styleguide\Pages\Zzsample', 'Base');

        $this->assertSame('Base', $this->getPageData('styleguide/zzsample')['title']);
    }

    #[Test]
    public function site_only_custom_page_should_load_ignoring_case(): void
    {
        $this->page('Styleguide\Pages\Custom\ZzSiteOnly', 'Site only');

        $this->assertSame('Site only', $this->getPageData('styleguide/zzsiteonly')['title']);
    }

    #[Test]
    public function custom_component_page_should_load_from_its_component_url(): void
    {
        $this->page('Styleguide\Pages\Custom\ComponentZzGrid', 'Grid');

        $this->assertSame('Grid', $this->getPageData('styleguide/component/zzgrid')['title']);
    }

    #[Test]
    public function prefixed_top_level_page_should_still_load(): void
    {
        $this->page('Styleguide\Pages\SitespecificZzsample', 'Prefixed');

        $this->assertSame('Prefixed', $this->getPageData('styleguide/sitespecific/zzsample')['title']);
    }

    #[Test]
    public function page_in_another_subfolder_should_not_load(): void
    {
        $this->page('Styleguide\Pages\Other\Zzother', 'Other');

        $this->expectException(NotFoundHttpException::class);

        $this->getPageData('styleguide/zzother');
    }

    #[Test]
    public function matched_class_that_is_not_a_page_should_404(): void
    {
        Storage::disk('base')->put('styleguide/Pages/Custom/Zznotapage.php', '');
        $this->app->instance('Styleguide\Pages\Custom\Zznotapage', new \stdClass());

        $this->expectException(NotFoundHttpException::class);

        $this->getPageData('styleguide/zznotapage');
    }

    #[Test]
    public function unknown_page_should_404(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $this->getPageData('styleguide/zzmissing');
    }

    /**
     * Put an empty page file on the fake disk and bind a fake page for its class.
     */
    protected function page(string $class, string $title): void
    {
        Storage::disk('base')->put(str_replace(['Styleguide\Pages', '\\'], ['styleguide/Pages', '/'], $class).'.php', '');

        $page = Mockery::mock(StyleguidePageContract::class);
        $page->shouldReceive('getPageData')->andReturn(['title' => $title]);

        $this->app->instance($class, $page);
    }

    protected function getPageData(string $path): array
    {
        $data = ['parameters' => ['path' => $path]];

        return app(PageRepository::class)->getRequestData($data);
    }
}
