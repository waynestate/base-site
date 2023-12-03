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
        $promos = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        $this->assertCount(count($return['promotions']), $promos['accordion-1']['data']);
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
    public function get_modular_page_components_with_json_array_should_have_singleview_excerpt_and_description(): void
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
        $component = collect($components['accordion-1']['data'])->first();

        $this->assertTrue($components['accordion-1']['component']['singlePromoView']);
        $this->assertTrue($components['accordion-1']['component']['showExcerpt']);
        $this->assertTrue($components['accordion-1']['component']['showDescription']);
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
}
