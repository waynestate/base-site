<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\Attributes\Test;
use App\Repositories\HomepageRepository;
use Factories\GenericPromo;
use Factories\Page;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;

final class HomepageRepositoryTest extends TestCase
{
    #[Test]
    public function getting_homepage_promos_should_return_array(): void
    {
        $promo_return = app(GenericPromo::class)->create(4, false);

        // Fake return
        $return = [
            'promotion' => $promo_return,
        ];

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(HomepageRepository::class, ['wsuApi' => $wsuApi])->getHomepagePromos($promo_return);

        $this->assertTrue(is_array($promos));
    }

    #[Test]
    public function override_news_events_component_with_page_field(): void
    {
        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'HomepageController',
            ],
            'data' => [
                'modular-news-and-events-row-1' => json_encode([
                    'events_id' => 1,
                    'news_id' => 1,
                ]),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);

        // Run the promos through the repository
        $data = app(HomepageRepository::class, ['wsuApi' => $wsuApi])->getHomepageComponents($data);

        $this->assertArrayHasKey('data', $data['components']['news-and-events-row-1']);
    }
}
