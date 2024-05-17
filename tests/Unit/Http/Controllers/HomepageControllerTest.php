<?php

namespace Tests\Unit\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Controllers\HomepageController;
use App\Repositories\ModularPageRepository;
use App\Repositories\PromoRepository;
use Styleguide\Pages\Homepage;
use Factories\Page;
use Factories\GenericPromo;
use Factories\Catalog;
use Mockery as Mockery;
use Waynestate\Api\Connector;

final class HomepageControllerTest extends TestCase
{

    #[Test]  
    #[Description('Test if the homepage controller is returning the modular component array data.')]
    public function homepage_with_modular_components_should_return_to_the_view(): void
    {
        // Fake request
        $request = new Request();
        $base['base'] = app(Homepage::class)->getPageData();
        $request->data = $base;

        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'HomepageController',
            ],
            'data' => [
                'modular-catalog-1' => json_encode([
                    'id' => $promo_group_id,
                    'config' => 'randomize|limit:2',
                ]),
            ],
        ]);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(3, false, [
            'promo_group_id' => $promo_group_id,
            'group' => [
                'promo_group_id' => $promo_group_id,
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);
        
        // Pass in the modular repository component data
       // $modularComponents['modularComponents'] = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularComponents($data);

        // Create a modular catalog component
        $request->data['base']['data']['modular-catalog-1'] = json_encode(['id' => $promo_group_id]);

        // Construct the modular repository
        $modularRepository = app(ModularPageRepository::class, ['wsuApi' => $wsuApi]);

        // Construct the homepage controller
        $this->modularComponent = app(HomepageController::class, ['modularComponent' => $modularRepository]);

        // Create the view
        $view = $this->modularComponent->index($request);
        // $this->assertTrue(is_array($HomepageController));
    }
}
