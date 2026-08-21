<?php

namespace Styleguide\Pages;

use Contracts\Repositories\ModularPageRepositoryContract;
use Factories\Page as PageFactory;
use Faker\Factory;
use Factories\GenericPromo;
use Factories\PromoWithOptions;

class ComponentCatalog extends Page
{
    /**
     * Construct the controller.
     *
     */
    public function __construct(
        Factory $faker,
        ModularPageRepositoryContract $components,
    ) {
        $this->faker['faker'] = $faker->create();
        $this->components = $components;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        $page_content = '
<p>The catalog component is ideal for showcasing a collection of items from a single promo group in a multiple-column grid or single-column list format.</p>
';
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
        ];

        $configs = [
            'modular-catalog-1' => [
                'factory' => 'GenericPromo',
                'id' => 1,
                'heading' => 'Three-column catalog',
                'config' => 'limit:3',
                'limit' => 3,
                'filename' => 'catalog',
                'columns' => '3',
                'showDescription' => false,
            ],
            'modular-catalog-2' => [
                'factory' => 'GenericPromo',
                'id' => 2,
                'heading' => 'One-column catalog',
                'config' => 'limit:3',
                'limit' => 3,
                'filename' => 'catalog',
                'columns' => '1',
                'showDescription' => false,
            ],
            'modular-catalog-9' => [
                'factory' => 'GenericPromo',
                'id' => 9,
                'heading' => 'Two-column catalog',
                'config' => 'limit:2',
                'limit' => 2,
                'filename' => 'catalog',
                'columns' => '2',
                'showDescription' => false,
            ],
            'modular-catalog-3' => [
                'factory' => 'PromoWithOptions',
                'id' => 3,
                'heading' => 'Four-column catalog sorted by option',
                'config' => 'limit:16',
                'limit' => 16,
                'filename' => 'catalog',
                'columns' => '4',
                'showDescription' => true,
                'groupByOptions' => true,
            ],
            'modular-catalog-5' => [
                'factory' => 'GenericPromo',
                'id' => 5,
                'heading' => 'Catalog with gradient overlay',
                'config' => 'limit:3',
                'limit' => 3,
                'filename' => 'catalog',
                'columns' => '3',
                'showDescription' => false,
                'gradientOverlay' => true,
            ],
            'modular-catalog-6' => [
                'factory' => 'GenericPromo',
                'id' => 6,
                'heading' => 'Catalog without images',
                'config' => 'limit:3',
                'limit' => 3,
                'filename' => 'catalog',
                'columns' => '3',
                'showDescription' => true,
            ],
        ];

        $page_data = collect($configs)->map(function($componentdata) {
            return json_encode($componentdata);
        })->toArray();

        // See styleguide modular repository

        $page = app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Catalog',
                'id' => 118100,
                'content' => [
                    'main' => $page_content,
                ],
            ],
            'data' => $page_data,
            'styleguide_accordion' => $accordion
        ]);

        return $page;
    }
}
