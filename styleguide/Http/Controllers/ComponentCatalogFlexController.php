<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\GenericPromo;

class ComponentCatalogFlexController extends Controller
{
    /**
     * Construct the controller.
     *
     */
    public function __construct(
        Factory $faker,
        ModularPageRepositoryContract $components
    ) {
        $this->faker['faker'] = $faker->create();
        $this->components = $components;
    }

    /**
     * Catalog Flex Controller
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p>The catalog flex component is ideal for showcasing a collection of items from a single promo group in a 3-column grid on large that is centered</p>
';

        $components = [
            'accordion' => [
                'data' => [
                    2 => [
                        'promo_item_id' => 'component_config',
                        'title' => 'Component configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-catalog-flex-1',
                            'Data' => '{
"id":000000,
"heading":"Catalog flex",
"config":"randomize|limit:3",
"singlePromoView":true,
"showExcerpt":true,
"showDescription":false,
"groupByOptions":false,
"gradientOverlay":false
}',
                        ],
                    ],
                    1 => [
                        'promo_item_id' => 'promo_details',
                        'title' => 'Promotion group details',
                        'description' => '',
                        'table' => [
                            'Title' => 'Bold text.',
                            'Link' => 'Optional external link. Component flag "singlePromoView" sets the link to the individual promo item view.',
                            'Excerpt' => 'Optional smaller text under the title.',
                            'Description' => 'Optional smaller text under the title and/or excerpt. You might use this area on a singe promo view page and hide it from the catalog component.',
                            'Primary image' => 'Minimum width of 600px jpg, png.',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                ],
            ],
            'catalog-flex-1' => [
                'data' => app(GenericPromo::class)->create(5, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Catalog flex',
                    'filename' => 'catalog-flex',
                    'columns' => '3',
                    'showDescription' => false,
                ],
            ],
        ];

        $components = $this->components->componentClasses($components);
        $components = $this->components->componentStyles($components);

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data, $components));
    }
}
