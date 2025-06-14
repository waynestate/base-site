<?php

namespace Tests\Unit\Repositories;

use Factories\Article;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use App\Repositories\ModularPageRepository;
use Factories\Page;
use Factories\GenericPromo;
use Factories\PromoWithOptions;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;
use Waynestate\Api\News;
use Factories\EventFullListing;

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
                'controller' => 'ChildpageController',
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
                'controller' => 'ChildpageController',
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
    public function get_modular_page_components_page_heading_and_page_content(): void
    {
        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
            ],
            'data' => [
                'modular-page-content' => '{}',
                'modular-heading' => '{"heading": "Test"}',
            ],
        ]);

        // Run the promos through the repository
        $components = app(ModularPageRepository::class)->getModularComponents($data);

        $this->assertArrayHasKey('data', $components['page-content']);
        $this->assertArrayHasKey('heading', $components['heading']['data'][0]);
        $this->assertTrue(empty($components['heading']['component']['heading']));
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
                'controller' => 'ChildpageController',
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
                'controller' => 'ChildpageController',
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

        $this->assertCount(count($return['data']), $modularComponents['news-row-1']['data']);
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
                'controller' => 'ChildpageController',
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

        $this->assertCount(count($return['data']), $modularComponents['news-column-1']['data']);
    }

    #[Test]
    public function get_modular_page_components_events(): void
    {
        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
            ],
            'data' => [
                'modular-events-column-1' => json_encode([
                    'id' => 1,
                    'cal_name' => '',
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
    public function get_modular_page_events_cal_name(): void
    {
        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
            ],
            'data' => [
                'modular-events-column-1' => json_encode([
                    'id' => 1,
                    'cal_name' => 'mycal/',
                ]),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn([]);

        // Run the promos through the repository
        $modularComponents = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);
        $component = collect($modularComponents)->first();

        $this->assertTrue(!empty($component['component']['cal_name']));
        $this->assertEquals($component['component']['cal_name'], 'mycal/');
    }

    #[Test]
    public function get_modular_page_events_default_cal_path(): void
    {
        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'site' => [
                'events' => [
                    'path' => 'default/'
                ],
            ],
            'page' => [
                'controller' => 'ChildpageController',
            ],
            'data' => [
                'modular-events-column-1' => json_encode([
                    'id' => 1,
                ]),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn([]);

        // Run the promos through the repository
        $modularComponents = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);
        $component = collect($modularComponents)->first();

        $this->assertTrue(!empty($component['component']['cal_name']));
    }

    #[Test]
    public function get_modular_page_events_full_listing(): void
    {
        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
            ],
            'data' => [
                'modular-events-featured-column-1' => json_encode([
                    'id' => 1,
                ]),
            ],
        ]);

        //$data['data']['components']['modular-events-featured-column-1']['data'] = app(EventFullListing::class)->create(4);
        $events = app(EventFullListing::class)->create(4);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn([]);

        // Run the promos through the repository
        $component = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        // TODO figure out how to get events to return with the component
        $this->assertArrayHasKey('filename', $component['events-featured-column-1']['component']);
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
                'controller' => 'ChildpageController',
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
                'controller' => 'ChildpageController',
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
                'controller' => 'ChildpageController',
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
                'controller' => 'ChildpageController',
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
                'controller' => 'ChildpageController',
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
                'controller' => 'ChildpageController',
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
                'controller' => 'ChildpageController',
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
                'controller' => 'ChildpageController',
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
    public function return_modular_promos_by_option(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(PromoWithOptions::class)->create(15, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
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

        $this->assertTrue(!empty($components['catalog-1']['data']['']));
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
                'controller' => 'ChildpageController',
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

    #[Test]
    public function replace_modular_page_relative_url_with_filename_if_on_base(): void
    {
        $page_id = $this->faker->numberbetween(10, 50);
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(5, false, [
            'relative_url' => '/promo/image.jpg',
            'filename_url' => 'https://base.wayne.edu/promo/image.jpg',
            'secondary_relative_url' => '/promo/image2.jpg',
            'secondary_filename_url' => 'https://base.wayne.edu/promo/image2.jpg',
            'promo_group_id' => $promo_group_id,
            'page_id' => $page_id,
            'group' => [
                'promo_group_id' => $promo_group_id,
            ],
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'site' => [
                'id' => 1561,
            ],
            'page' => [
                'controller' => 'ChildpageController',
                'id' => $page_id,
            ],
            'data' => [
                'modular-promo-column-1' => json_encode([
                    'id' => $promo_group_id,
                    'config' => 'randomize|limit:2',
                ]),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);
        $component = collect($components['promo-column-1']['data'])->first();

        $this->assertTrue($component['relative_url'] === $component['filename_url']);
        $this->assertTrue($component['secondary_relative_url'] === $component['secondary_filename_url']);
    }
}
