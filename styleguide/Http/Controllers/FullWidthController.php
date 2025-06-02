<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\HeroImage;
use Factories\Icon;
use Factories\Spotlight;
use Factories\Button;
use Factories\GenericPromo;
use Factories\ArticleMeta;
use Factories\ArticleComponent;
use Factories\Event;

class FullWidthController extends Controller
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
     * Display the full width hero view.
     */
    public function index(Request $request): View
    {
        $request->data['base']['show_site_menu'] = false;

        config([
            'base.full_width_controllers' => ['FullWidthController'],
            'base.top_menu_enabled' => true,
        ]);

        $components = [
            'hero_1' => [
                'data' => app(HeroImage::class)->create(1, false, [
                    'option' => 'Text overlay',
                    'title' => 'Your future <em>starts here</em>',
                    'description' => '',
                    'link' => '',
                ]),
                'component' => [
                    'filename' => 'hero',
                ],
            ],

            // Icons row
            'icons-row-100' => [
                'data' => app(Icon::class)->create(6, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'filename' => 'icons-row',
                    'columns' => 2,
                    'backgroundImageUrl' => '/styleguide/image/3200x1140',
                    'heading' => 'Icons row',
                    'classes' => 'py-gutter-lg',
                ],
            ],

            // Icons accordion
            'accordion-101' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-icons',
                        'title' => 'Icons row configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-icons-row-1',
                            'Data' => '{
"id": 0,
"heading": "Icons row"
"columns": 2,
"backgroundImageUrl": "/styleguide/image/3200x1140",
"classes": "py-gutter-lg",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter-sm'
                ],
            ],
            // Catalog with background
            'catalog-200' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Catalog with background',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                    'classes' => 'bg-gray-100 bg-top py-gutter-xl',
                ],
            ],

            // Catalog with background accordion
            'accordion-201' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-catalog',
                        'title' => 'Catalog with background configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-catalog',
                            'Data' => '{
"id": 0,
"heading": "Catalog with background"
"columns": 3,
"classes": "bg-gray-100 py-gutter-xl",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter-sm'
                ],
            ],

            // Resources - heading
            'heading-300' => [
                'data' => [
                    0 => [
                        'heading' => 'Resources',
                    ],
                ],
                'component' => [
                    'filename' => 'heading',
                ],
            ],

            // Resources - image
            'promo-column-301' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Preview (promo column)',
                    'relative_url' => '/styleguide/image/770x434',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => '',
                    'filename' => 'promo-column',
                    'gradientOverlay' => true,
                    'columnSpan' => 6,
                ],
            ],

            // Resources - accordion
            'accordion-302' => [
                'data' => app(GenericPromo::class)->create(4, false),
                'component' => [
                    'filename' => 'accordion',
                    'columnSpan' => 6,
                    'classes' => 'end',
                ],
            ],

            // Resources - configuration accordion
            'accordion-303' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-resources',
                        'title' => 'Resources area configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-heading',
                            'Data' => '{
"heading": "Resources"
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-promo-column',
                            'Data' => '{
"id": 0,
"gradientOverlay":true,
"columnSpan": 6,
}',
                        ],
                        'tr3' => [
                            'Page field' => 'modular-accordion',
                            'Data' => '{
"id": 0,
"columnSpan": 6,
"classes": "end",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter-sm'
                ],
            ],

            // News
            'news-row-400' => [
                'data' => app(ArticleComponent::class)->create(4, false),
                'meta' => app(ArticleMeta::class)->create(),
                'component' => [
                    'heading' => 'News',
                    'filename' => 'news-row',
                    'classes' => 'bg-gray-100 py-gutter-lg',
                ],
            ],

            // News - configuration accordion
            'accordion-401' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-news',
                        'title' => 'News configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-news-row',
                            'Data' => '{
"heading": "My news"
"classes": "bg-gray-100 py-gutter-lg",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter-sm'
                ],
            ],

            // Events - Promo image
            'promo-column-501' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Featured event (promo column)',
                    'relative_url' => '/styleguide/image/600x600',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => '',
                    'filename' => 'promo-column',
                    'gradientOverlay' => true,
                    'columnSpan' => 5,
                ],
            ],

            // Events - Column
            'events-column-502' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Events',
                    'filename' => 'events-column',
                    'columnSpan' => 7,
                ],
            ],

            // Events - Configuration accordion
            'accordion-503' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-events',
                        'title' => 'Events area configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-promo-column',
                            'Data' => '{
"id": 0,
"gradientOverlay": true,
"columnSpan": 5,
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-events-column',
                            'Data' => '{
"heading": "My events",
"columnSpan": 7,
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter-sm'
                ],
            ],

            // Icons top row
            'icons-row-600' => [
                'data' => app(Icon::class)->create(4, false, [
                    'link' => '',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Facts',
                    'filename' => 'icons-top-row',
                    'columns' => 4,
                    'classes' => 'pt-gutter-xl bg-gray-100'
                ],
            ],

            // Icons top row - Button
            'button-row-601' => [
                'data' => app(Button::class)->create(1, false, [
                    'title' => 'Get more facts',
                    'option' => 'Green gradient',
                    'excerpt' => '',
                ]),
                'component' => [
                    'filename' => 'button-row',
                    'columns' => 1,
                    'classes' => 'pt-gutter-lg pb-gutter-xl bg-gray-100 -mt-gutter-md'
                ],
            ],

            // Icons top row - Configuration accordion
            'accordion-602' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-facts',
                        'title' => 'Facts area configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-icons-top-row',
                            'Data' => '{
"id": 0,
"heading": "Facts",
"columns": 4,
"classes": "pt-gutter-xl bg-gray-100",
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-button-row',
                            'Data' => '{
"id": 0,
"columns": 1,
"classes": "pt-gutter-lg pb-gutter-xl bg-gray-100 -mt-gutter-sm",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter-sm'
                ],
            ],

            // Single column catalog
            'catalog-700' => [
                'data' => app(GenericPromo::class)->create(2, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Single column catalog',
                    'filename' => 'catalog',
                    'columns' => '1',
                    'showDescription' => false,
                    'imageSize' => 'small',
                    'columnSpan' => 8,
                ],
            ],

            // Button column
            'button-column-701' => [
                'data' => app(Button::class)->create(4, false, [
                    'option' => 'Default',
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Button column',
                    'filename' => 'button-column',
                    'columnSpan' => 4,
                    'classes' => 'end',
                ],
            ],

            // Single column catalog and buttons - configuration accordion
            'accordion-702' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-catalog-and-buttons',
                        'title' => 'Single column catalog and buttons area configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-catalog',
                            'Data' => '{
"id": 0,
"columns": 1,
"showDescription": false,
"imageSize": "small",
"columnSpan": 8,
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-button-column',
                            'Data' => '{
"id": 0,
"columnSpan": 4,
"classes": "end",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter-sm'
                ],
            ],

            // Spotlight row
            'spotlight-row-800' => [
                'data' => app(Spotlight::class)->create(1, false),
                'component' => [
                    'heading' => 'Spotlight',
                    'filename' => 'spotlight-row',
                    'showDescription' => true,
                    'classes' => 'bg-gold-50 py-gutter-xl'
                ],
            ],

            // Spotlight row - configuration accordion
            'accordion-801' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-spotlight-row',
                        'title' => 'Spotlight row area configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-spotlight-row',
                            'Data' => '{
"id": 0,
"showDescription": true,
"classes": "bg-gold-50 py-gutter-xl",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter-sm'
                ],
            ],

            // Narrow column
            'promo-row-900' => [
                'data' => app(GenericPromo::class)->create(2, false),
                'component' => [
                    'heading' => 'Narrow column',
                    'filename' => 'promo-row',
                    'imagePosition' => 'alternate',
                    'columnSpan' => 10,
                    'classes' => 'end'
                ],
            ],

            // Narrow column - configuration accordion
            'accordion-901' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-smaller-width',
                        'title' => 'Smaller-width area configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-promo-row',
                            'Data' => '{
"id": 0,
"imagePosition": "alternate",
"columnSpan": 10,
"classes": "end",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter-sm'
                ],
            ],

            // Button row
            'button-row-1000' => [
                'data' => app(Button::class)->create(3, false, [
                ]),
                'component' => [
                    'heading' => 'Button row with background image',
                    'filename' => 'button-row',
                    'backgroundImageUrl' => '/_resources/images/background.svg',
                    'classes' => 'py-gutter-xl px-4 pt-xl pb-xl mt-gutter-lg text-white',
                    'sectionStyle' => 'background-size:350px;',
                ],
            ],

            // Button row - configuration accordion
            'accordion-1001' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-button-row',
                        'title' => 'Button row area configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-button-row',
                            'Data' => '{
"id": 0,
"backgroundImageUrl": "/_resources/images/background.svg",
"classes": "py-gutter-xl",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'classes' => '-mt-gutter-sm mb-gutter-xl'
                ],
            ],

        ];

        if (!empty($components)) {
            // Set hero from components
            $hero = collect($components)->reject(function ($data, $component_name) {
                return !str_contains($component_name, 'hero');
            })->toArray();
        }

        if (!empty($hero)) {
            $hero_key = array_key_first($hero);

            $request->data['base']['hero'] = $components[$hero_key]['data'];

            unset($components[$hero_key]);

            config(['base.hero_full_controllers' => ['ChildpageWithComponentsController']]);
        }

        $heroClass['heroClass'] = 'full-width-styleguide-hero';

        $components = $this->components->componentClasses($components);
        $components = $this->components->componentStyles($components);

        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data, $this->faker, $components, $heroClass));
    }
}
