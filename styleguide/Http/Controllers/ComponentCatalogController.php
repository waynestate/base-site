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
        $request->data['base']['page']['content']['main'] = '
<p>The catalog component is ideal for showcasing a collection of items from a single promo group in a multiple-column grid or single-column list format.</p>
';

        $components = [
            'accordion' => [
                'data' => [
                    2 => [
                        'promo_item_id' => 'component_config',
                        'title' => 'Component configuration',
                        'description' => '<p>Image size can only be used with a one-column catalog.</p>',
                        'tr1' => [
                            'Page field' => 'modular-catalog-1',
                            'Data' => '{
"id":000000,
"heading":"Catalog",
"config":"randomize|limit:3",
"columns":3,
"singlePromoView":true,
"showExcerpt":true,
"showDescription":false,
"groupByOptions":false,
"gradientOverlay":false,
"imageSize":"small"
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
            'catalog-1' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Three-column catalog',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                ],
            ],
            'catalog-2' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                ]),
                'component' => [
                    'heading' => 'One-column catalog',
                    'filename' => 'catalog',
                    'columns' => '1',
                    'showDescription' => false,
                ],
            ],
            'catalog-9' => [
                'data' => app(GenericPromo::class)->create(2, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Two-column catalog',
                    'filename' => 'catalog',
                    'columns' => '2',
                    'showDescription' => false,
                ],
            ],
            'catalog-3' => [
                'data' => app(PromoWithOptions::class)->create(8, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Four-column catalog sorted by option',
                    'filename' => 'catalog',
                    'columns' => '4',
                    'showDescription' => true,
                    'groupByOptions' => true,
                ],
            ],
            'catalog-5' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'relative_url' => '/styleguide/image/450x600',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Catalog with gradient overlay',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                    'gradientOverlay' => true,
                ],
            ],
            'catalog-6' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'relative_url' => '',
                    'excerpt' => '',
                    'youtube_id' => '',
                    'link' => '',
                ]),
                'component' => [
                    'heading' => 'Catalog without images',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => true,
                ],
            ],
        ];

        $components = $this->components->componentClasses($components);
        $components = $this->components->componentStyles($components);

        $components['catalog-3']['data'] = $this->components->organizePromoItemsByOption($components['catalog-3']['data']);

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data, $components));
    }
}
