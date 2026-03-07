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
        $pages = [
            '118100100' => [
                'columns' => 1,
                'count' => 3,
                'heading' => 'One',
                'imageSize' => 'small',
                'grid_image' => '',
            ],
            '118100200' => [
                'columns' => 2,
                'count' => 2,
                'heading' => 'Two',
                'grid_image' => '',
            ],
            '118100300' => [
                'columns' => 3,
                'count' => 3,
                'heading' => 'Three',
                'grid_image' => '',
            ],
            '118100400' => [
                'columns' => 4,
                'count' => 4,
                'heading' => 'Four',
                'group_count' => 16,
                'grid_image' => '',
            ],
        ];

        $page_id = $request->data['base']['page']['id'];
        $heading = $pages[$page_id]['heading'];
        $columns = $pages[$page_id]['columns'];
        $count = $pages[$page_id]['count'];
        $image_size = $pages[$page_id]['imageSize'] ?? null;


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

            // All data showing
            'catalog-1' => [
                'data' => app(GenericPromo::class)->create($count ?? 3, false, [
                    'relative_url' => '/styleguide/image/600x450?text=600x450',
                ]),
                'component' => [
                    'heading' => $heading.'-column catalog',
                    'filename' => 'catalog',
                    'columns' => $columns,
                    'imageSize' => $image_size ?? null,
                ],
            ],

            // Excerpt only
            'catalog-2' => [
                'data' => app(GenericPromo::class)->create($count ?? 3, false, [
                    'description' => ''
                ]),
                'component' => [
                    'heading' => $heading.'-column catalog',
                    'filename' => 'catalog',
                    'columns' => $columns,
                ],
            ],

            // Description only
            'catalog-3' => [
                'data' => app(GenericPromo::class)->create($count ?? 3, false, [
                    'excerpt' => ''
                ]),
                'component' => [
                    'heading' => $heading.'-column catalog',
                    'filename' => 'catalog',
                    'columns' => $columns,
                ],
            ],

            // Gradient overlay - All data showing
            'catalog-4' => [
                'data' => app(GenericPromo::class)->create($count ?? 3, false, [
                    'relative_url' => '/styleguide/image/450x600?text=450x600',
                ]),
                'component' => [
                    'heading' => $heading.'-column catalog, gradient overlay',
                    'filename' => 'catalog',
                    'columns' => $columns,
                    'gradientOverlay' => true,
                ],
            ],

            // Gradient overlay - Excerpt only
            'catalog-5' => [
                'data' => app(GenericPromo::class)->create($count ?? 3, false, [
                    'relative_url' => '/styleguide/image/450x600?text=450x600',
                    'description' => ''
                ]),
                'component' => [
                    'heading' => $heading.'-column catalog, gradient overlay',
                    'filename' => 'catalog',
                    'columns' => $columns,
                    'gradientOverlay' => true,
                    'groupByOptions' => $group_by_options ?? false,
                ],
            ],

            // Gradient overlay - Description only
            'catalog-6' => [
                'data' => app(GenericPromo::class)->create($count ? $count * 2 : 3, false, [
                    'relative_url' => '/styleguide/image/450x600?text=450x600',
                    'excerpt' => ''
                ]),
                'component' => [
                    'heading' => $heading.'-column catalog, gradient overlay',
                    'filename' => 'catalog',
                    'columns' => $columns,
                    'gradientOverlay' => true,
                    'groupByOptions' => $group_by_options ?? false,
                ],
            ],
        ];

        foreach($components as $componentName => $componentData) {
            if(!empty($componentData['component']['groupByOptions']) && $componentData['component']['groupByOptions'] === true) {
                $components[$componentName]['data'] = $this->components->organizePromoItemsByOption($components[$componentName]['data']);
            }
        }

        $components = $this->components->componentClasses($components);
        $components = $this->components->componentStyles($components);

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data, $components));
    }
}
