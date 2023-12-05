<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\Attributes\Test;
use App\Repositories\HomepageRepository;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;

final class HomepageRepositoryTest extends TestCase
{
    #[Test]
    public function getting_homepage_promos_should_return_array(): void
    {
        // Fake return
        $return = [
            'promotions' => [],
        ];

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(HomepageRepository::class, ['wsuApi' => $wsuApi])->getHomepagePromos($this->faker->randomDigit());

        $this->assertTrue(is_array($promos));
    }
}
