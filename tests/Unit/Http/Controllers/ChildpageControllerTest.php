<?php

namespace Tests\Unit\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ChildpageController;
use App\Repositories\ModularPageRepository;
use Styleguide\Pages\ChildpageWithComponents;
use Factories\GenericPromo;
use Mockery as Mockery;
use Waynestate\Api\Connector;

final class ChildpageControllerTest extends TestCase
{
    #[Test]
    public function childpage_with_hero_component_replaces_base_hero(): void
    {
        // Fake request
        $request = new Request();
        $base['base'] = app(ChildpageWithComponents::class)->getPageData();
        $request->data = $base;

        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Create a hero 
        $request->data['base']['data']['modular-hero-1'] = json_encode(['id' => $promo_group_id]);

        // Construct the modular repository
        $components = app(ModularPageRepository::class, ['wsuApi' => $wsuApi]);

        // Construct the childpage with modular components controller
        $ChildpageController = app(ChildpageController::class, ['components' => $components]);

        // Create the view
        $view = $ChildpageController->index($request);

        $this->assertEquals($return['promotions'], $view->getData()['base']['hero']);
    }
}
