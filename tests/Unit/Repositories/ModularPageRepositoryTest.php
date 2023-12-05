<?php

namespace Tests\Unit\Repositories;

use Factories\Article;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use App\Repositories\ModularPageRepository;
use Factories\Page;
use Factories\GenericPromo;
use Factories\PromoPageWithOptions;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;
use Waynestate\Api\News;

final class ModularPageRepositoryTest extends TestCase
{
    #[Test]
    public function get_modular_page_components_with_json_array(): void
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
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        $this->assertCount(count($return['promotions']), $components['accordion-1']['data']);
    }

    #[Test]
    public function get_modular_page_components_with_promo_id_only(): void
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
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        $this->assertCount(count($return['promotions']), $components['accordion-1']['data']);
    }

    #[Test]
    public function get_modular_page_components_with_json_array_should_not_have_singleview_excerpt_and_description(): void
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
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);
        $component = collect($components['accordion-1']['data'])->first();

        $this->assertFalse($components['accordion-1']['component']['singlePromoView']);
        $this->assertFalse($components['accordion-1']['component']['showExcerpt']);
        $this->assertFalse($components['accordion-1']['component']['showDescription']);
        $this->assertNotEquals($component['link'], 'view/'.Str::slug($component['title']).'-'.$component['promo_item_id']);
        $this->assertArrayNotHasKey('excerpt', $component);
        $this->assertArrayNotHasKey('description', $component);
    }

    #[Test]
    public function get_modular_page_components_featured_news(): void
    {
        // Fake return
        $return = app(Article::class)->create(4);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPage',
            ],
            'data' => [
                'modular-news-row-1' => json_encode([
                    'id' => 1,
                    'featured' => true,
                ]),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn([]);

        // Run the promos through the repository
        $modularComponents = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        $this->assertCount(count($return['data']), $modularComponents['news-row-1']['data']['data']);
    }

    #[Test]
    public function get_modular_page_components_news(): void
    {
        // Fake return
        $return = app(Article::class)->create(4);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPage',
            ],
            'data' => [
                'modular-news-column-1' => json_encode([
                    'id' => 1
                ]),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn([]);

        // Run the promos through the repository
        $modularComponents = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        $this->assertCount(count($return['data']), $modularComponents['news-column-1']['data']['data']);
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
                'modular-events-column-1' => json_encode([
                    'id' => 1
                ]),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn([]);

        // Run the promos through the repository
        $modularComponents = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        $this->assertArrayHasKey('data', $modularComponents['events-column-1']);
    }

    #[Test]
    public function get_all_modular_page_config_options(): void
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
                'modular-catalog-1' => json_encode([
                    'id' => $promo_group_id,
                    'config' => 'randomize|limit:20|page_id|first',
                    'columns' => '2',
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
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);
        $component = collect($components['catalog-1']['data'])->first();
        $config = $components['catalog-1']['component'];

        $this->assertTrue(Str::contains($config['config'], $page_id));
        $this->assertTrue(!empty($config['columns']));
        $this->assertTrue($config['singlePromoView']);
        $this->assertTrue($config['showExcerpt']);
        $this->assertTrue($config['showDescription']);
        $this->assertEquals($component['link'], 'view/'.Str::slug($component['title']).'-'.$component['promo_item_id']);
        $this->assertArrayHasKey('excerpt', $component);
        $this->assertArrayHasKey('description', $component);
    }

    #[Test]
    public function get_modular_page_with_no_data_should_return_empty(): void
    {
        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPage',
                'id' => $this->faker->numberbetween(10, 50),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);

        // Run the promos through the repository
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        $this->assertEmpty($components);
    }

    #[Test]
    public function get_modular_page_test_json_configuration(): void
    {
        $page_id = $this->faker->numberbetween(10, 50);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPage',
                'id' => $page_id,
            ],
            'data' => [
                'modular-accordion-1' => json_encode([
                    'singlePromoView' => false,
                    'showExcerpt' => false,
                    'showDescription' => false,
                ]),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn([]);

        // Run the promos through the repository
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        $this->assertEmpty($components['accordion-1']['data']);
    }

    #[Test]
    public function modular_page_returns_legacy_accordion_page_array(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'Childpage',
            ],
            'data' => [
                'accordion_promo_group_id' => $promo_group_id,
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        $this->assertCount(count($return['promotions']), $components['accordion-999']['data']);
    }

    #[Test]
    public function modular_page_returns_legacy_promo_listing_array(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'Childpage',
            ],
            'data' => [
                'listing_promo_group_id' => $promo_group_id,
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        $this->assertCount(count($return['promotions']), $components['catalog-998']['data']);
    }

    #[Test]
    public function modular_page_returns_legacy_promo_grid_array(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'Childpage',
            ],
            'data' => [
                'grid_promo_group_id' => $promo_group_id,
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        $this->assertCount(count($return['promotions']), $components['catalog-999']['data']);
    }

    #[Test]
    public function promo_page_returns_legacy_listing_array_with_individual_view(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(1, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoPagePromos',
            ],
            'data' => [
                'listing_promo_group_id' => $promo_group_id,
                'promotion_view_boolean' => 'true',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);
        $component = collect($components['catalog-998']['data'])->first();

        $this->assertEquals($component['link'], 'view/'.Str::slug($component['title']).'-'.$component['promo_item_id']);
    }


    #[Test]
    public function promo_page_returns_legacy_grid_array_with_individual_view(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoPagePromos',
            ],
            'data' => [
                'grid_promo_group_id' => $promo_group_id,
                'promotion_view_boolean' => 'true',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);
        $component = collect($components['catalog-999']['data'])->first();

        $this->assertEquals($component['link'], 'view/'.Str::slug($component['title']).'-'.$component['promo_item_id']);
    }


    #[Test]
    public function promo_page_parse_json_returns_promos_by_option(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(PromoPageWithOptions::class)->create(1, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'Childpage',
            ],
            'data' => [
                'modular-catalog-1' => '{
"id":'. $promo_group_id .',
"config":"randomize|limit:20",
"columns":"",
"singlePromoView":true,
"showExcerpt":true,
"showDescription":true,
"groupByOptions":true
}',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Group the fake return by option
        $return['promotions'] = collect($return['promotions'])->groupBy('option')->toArray();

        // Run the promos through the repository
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        $this->assertCount(count($return['promotions']), $components['catalog-1']['data']);
    }

    #[Test]
    public function promo_page_set_columns(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Fake return starts at 1 for some reason
        $return['promotions'] = array_values($return['promotions']);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'Childpage',
            ],
            'data' => [
                'modular-catalog-1' => '{
"id":'. $promo_group_id .',
"config":"randomize|limit:20",
"columns":"2"
}',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        $this->assertTrue(!empty($components['catalog-1']['component']['columns']));
    }
}
