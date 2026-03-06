<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\GenericPromo;
use Factories\PromoWithOptions;

class ComponentCatalogController extends Controller
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
     * Article Listing Controller
     */
    public function index(Request $request): View
    {

        $accordion = [
            'accordion' => [
                'data' => [
                    2 => [
                        'promo_item_id' => 'component_config',
                        'title' => 'Component configuration',
                        'description' => '<p>Image size can only be used with a one-column catalog.</p>',
                        'tr1' => [
                            'Page field' => 'modular-catalog-1',
                            'Data' => '{
// Basic options
"id":000000,
"columns":1,
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-catalog-1',
                            'Data' => '{
// Available options
"id":000000,
"heading":"Catalog",
"config":"limit:10",
"columns":1,
"imageSize":"small"
"showExcerpt":true,
"showDescription":false,
"singlePromoView":true,
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
        ];

        // One column components
        $components[118100100] = [
            'catalog-1' => [
                'data' => app(GenericPromo::class)->create(3, false),
                'component' => [
                    'heading' => 'One-column catalog, small images',
                    'filename' => 'catalog',
                    'columns' => '1',
                    'showDescription' => false,
                    'imageSize' => 'small',
                ],
            ],
            'catalog-2' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'page_id' => 118100100,
                ]),
                'component' => [
                    'heading' => 'One-column catalog',
                    'filename' => 'catalog',
                    'columns' => '1',
                    'showDescription' => false,
                ],
            ],
        ];

        // Two column components
        $components[118100200] = [
            'catalog-1' => [
                'data' => app(GenericPromo::class)->create(2, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Two-column catalog, one row',
                    'filename' => 'catalog',
                    'columns' => '2',
                    'showDescription' => false,
                ],
            ],
            'catalog-2' => [
                'data' => app(GenericPromo::class)->create(6, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Two-column catalog, gradient-overlay',
                    'filename' => 'catalog',
                    'columns' => '2',
                    'showDescription' => false,
                    'gradientOverlay' => true,
                ],
            ],
        ];

        // Three column components
        $components[118100300] = [
            'catalog-1' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Three-column catalog, one row',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                ],
            ],
            'catalog-2' => [
                'data' => app(GenericPromo::class)->create(6, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Three-column catalog, gradient-overlay',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                    'gradientOverlay' => true,
                ],
            ],
        ];

        // Four column components
        $components[118100400] = [
            'catalog-1' => [
                'data' => app(GenericPromo::class)->create(4, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Four-column catalog, one row',
                    'filename' => 'catalog',
                    'columns' => '4',
                    'showDescription' => false,
                ],
            ],
            'catalog-2' => [
                'data' => app(GenericPromo::class)->create(8, false, [
                    'relative_url' => '/styleguide/image/600x600?text=600x600',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Four-column catalog, gradient-overlay',
                    'filename' => 'catalog',
                    'columns' => '4',
                    'showDescription' => false,
                    'gradientOverlay' => true,
                ],
            ],
        ];

        // Grouped components
        $components[118100500] = [
            'catalog-1' => [
                'data' => app(PromoWithOptions::class)->create(18, false, [
                    'relative_url' => '/styleguide/image/600x600?text=600x600',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Four-column catalog, grouped items',
                    'filename' => 'catalog',
                    'columns' => '4',
                    'showDescription' => false,
                    'gradientOverlay' => true,
                    'groupByOptions' => true,
                ],
            ],
            'catalog-2' => [
                'data' => app(PromoWithOptions::class)->create(12, false, [
                    'relative_url' => '/styleguide/image/600x600?text=600x600',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Three-column catalog, grouped items',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                    'gradientOverlay' => true,
                    'groupByOptions' => true,
                ],
            ],
        ];

        $components[118100500]['catalog-1']['data'] = $this->components->organizePromoItemsByOption($components[118100500]['catalog-1']['data']);
        $components[118100500]['catalog-2']['data'] = $this->components->organizePromoItemsByOption($components[118100500]['catalog-2']['data']);

        $components = array_merge($accordion, $components[$request->data['base']['page']['id']]);

        $components = $this->components->componentClasses($components);
        $components = $this->components->componentStyles($components);


        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data, $components));
    }
}
