<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Tab;

class ComponentTabsController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(
        Factory $faker,
        ModularPageRepositoryContract $components
    ) {
        $this->faker['faker'] = $faker->create();
        $this->components = $components;
    }

    /**
     * Article Listing Controller
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p>Present a list of promotional items accompanied by icons, offering a visually appealing and informative display.</p>
';

        $components = [
            'accordion' => [
                'data' => [
                    0 => [
                        'title' => 'Component configuration',
                        'promo_item_id' => 'component_config',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-tabs-1',
                            'Data' => '{
"id":000000,
"heading":"Tabs column"
}',
                        ],
                    ],
                    1 => [
                        'title' => 'Promotion group details',
                        'promo_item_id' => 'promo_details',
                        'description' => '',
                        'table' => [
                            'Title' => 'Bold text.',
                            'Link' => 'Optional external link. Component flag "singlePromoView" sets the link to the individual promo item view.',
                            'Excerpt' => 'Optional smaller text under the title.',
                            'Description' => 'Optional smaller text under the title and/or excerpt. You might use this area on a singe promo view page and hide it from the component.',
                            'Primary image' => 'Minimum width of 160px svg, png, jpg.',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                ],
            ],
            'tabs-1' => [
                'data' => app(Tab::class)->create(4, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Tabs',
                    'filename' => 'tabs',
                ],
            ],
        ];

        $components = $this->components->componentClasses($components);
        $components = $this->components->componentStyles($components);

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data));
    }
}
