<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\Attributes\Test;
use App\Repositories\HomepageRepository;
use Factories\GenericPromo;
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
}
