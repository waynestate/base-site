<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\Attributes\Test;
use App\Repositories\ModularPageRepository;
use Factories\Page;
use Factories\GenericPromo;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;

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
                'modular-accordion-1' => '{
"id":'. $promo_group_id .',
"config":"randomize|limit:20|page_id|first",
"columns":"",
"singlePromoView":"true",
"showExcerpt":"true",
"showDescription":"true",
}',
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
}
