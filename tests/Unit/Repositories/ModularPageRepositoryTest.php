<?php

namespace Tests\Unit\Repositories;

use Factories\Article;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use App\Repositories\ModularPageRepository;
use Factories\Page;
use Factories\GenericPromo;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;
use Waynestate\Api\News;

final class ModularPageRepositoryTest extends TestCase
{
    #[Test]
    public function get_modular_page_promos_with_json_array(): void
    {
        $page_id = $this->faker->numberbetween(10, 50);
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
            'page_id' => $page_id,
            'group' => [
                'promo_group_id' => $promo_group_id,
            ],
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPage',
                'id' => $page_id,
            ],
            'data' => [
                'modular-accordion-1' => json_encode([
                    'id' => $promo_group_id,
                    'config' => 'randomize|limit:20|page_id|first',
                    'columns' => '',
                    'singlePromoView' => true,
                    'showExcerpt' => true,
                    'showDescription' => true,
                ]),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $promos = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularPromos($data);

        $this->assertCount(count($return['promotions']), $promos['accordion-1']);
    }

    #[Test]
    public function get_modular_page_promos_with_promo_id_only(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
            'group' => [
                'promo_group_id' => $promo_group_id,
            ],
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPage',
            ],
            'data' => [
                'modular-accordion-1' => $promo_group_id,
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $promos = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularPromos($data);

        $this->assertCount(count($return['promotions']), $promos['accordion-1']);
    }

    #[Test]
    public function get_modular_page_promos_with_json_array_should_not_have_singleview_excerpt_and_description(): void
    {
        $page_id = $this->faker->numberbetween(10, 50);
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
            'page_id' => $page_id,
            'group' => [
                'promo_group_id' => $promo_group_id,
            ],
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPage',
                'id' => $page_id,
            ],
            'data' => [
                'modular-accordion-1' => json_encode([
                    'id' => $promo_group_id,
                    'config' => 'randomize|limit:20|page_id|first',
                    'columns' => '',
                    'singlePromoView' => false,
                    'showExcerpt' => false,
                    'showDescription' => false,
                ]),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $promos = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularPromos($data);

        $promo = collect($promos['accordion-1'])->first();
        $this->assertFalse($promo['component']['singlePromoView']);
        $this->assertFalse($promo['component']['showExcerpt']);
        $this->assertFalse($promo['component']['showDescription']);
        $this->assertNotEquals($promo['link'], 'view/'.Str::slug($promo['title']).'-'.$promo['promo_item_id']);
        $this->assertArrayNotHasKey('excerpt', $promo);
        $this->assertArrayNotHasKey('description', $promo);
    }

    #[Test]
    public function get_modular_page_components_news(): void
    {
        // Fake return
        $return = app(Article::class)->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPage',
            ],
            'data' => [
                'modular-news' => 1
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn([]);

        // Run the promos through the repository
        $promos = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularPromos($data);

        $this->assertCount(count($return['data']), $promos['news']);
    }

    #[Test]
    public function get_modular_page_components_events(): void
    {
        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPage',
            ],
            'data' => [
                'modular-events' => 1
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn([]);

        // Run the promos through the repository
        $promos = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularPromos($data);

        $this->assertArrayHasKey('events', $promos);
    }

    #[Test]
    public function get_modular_page_promos_with_json_array_should_have_singleview_excerpt_and_description(): void
    {
        $page_id = $this->faker->numberbetween(10, 50);
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
            'page_id' => $page_id,
            'group' => [
                'promo_group_id' => $promo_group_id,
            ],
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPage',
                'id' => $page_id,
            ],
            'data' => [
                'modular-accordion-1' => json_encode([
                    'id' => $promo_group_id,
                    'config' => 'randomize|limit:20|page_id|first',
                    'columns' => '',
                    'singlePromoView' => true,
                    'showExcerpt' => true,
                    'showDescription' => true,
                ]),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $promos = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularPromos($data);

        $promo = collect($promos['accordion-1'])->first();
        $this->assertTrue($promo['component']['singlePromoView']);
        $this->assertTrue($promo['component']['showExcerpt']);
        $this->assertTrue($promo['component']['showDescription']);
        $this->assertEquals($promo['link'], 'view/'.Str::slug($promo['title']).'-'.$promo['promo_item_id']);
        $this->assertArrayHasKey('excerpt', $promo);
        $this->assertArrayHasKey('description', $promo);
    }
}
