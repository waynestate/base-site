<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\HeroImage;
use Factories\Spotlight;
use Factories\Button;
use Factories\GenericPromo;
use Factories\ArticleMeta;
use Factories\ArticleComponent;
use Factories\Event;
use Factories\Video;

class ChildpageWithComponentsController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(
        Factory $faker,
        ModularPageRepositoryContract $components
    ) {
        $this->faker = $faker->create();
        $this->components = $components;
    }

    /**
     * Display a childpage using components.
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p>This an example of CMS page content on a childpage with components.</p>
<p>'.$this->faker->paragraph(8).'</p>
<p>'.$this->faker->paragraph(8).'</p>
';
        $components = [
            'hero-1' => [
                'data' => app(HeroImage::class)->create(1, false, [
                    'relative_url' => '/styleguide/image/3200x600',
                    'option' => 'banner small',
                ]),
                'component' => [
                    'filename' => 'hero',
                ],
            ],

            // Button row
            'button_row_1' => [
                'data' => app(Button::class)->create(2, false, [
                    'option' => 'green',
                    'excerpt' => '',
                    //'relative_url' => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cGF0aCBkPSJNNTAgMi41QzIzLjggMi41IDIuNSAyMy44IDIuNSA1MFMyMy44IDk3LjUgNTAgOTcuNSA5Ny41IDc2LjIgOTcuNSA1MCA3Ni4yIDIuNSA1MCAyLjV6bS02LjIgMTguNGMxLjYtMS41IDMuNS0yLjIgNS42LTIuMiAyLjIgMCA0LjEuNyA1LjYgMi4yIDEuNiAxLjUgMi4zIDMuMiAyLjMgNS4zIDAgMi0uOCAzLjgtMi40IDUuMi0xLjYgMS40LTMuNCAyLjItNS42IDIuMi0yLjIgMC00LjEtLjctNS42LTIuMi0xLjYtMS40LTIuNC0zLjItMi40LTUuMi4xLTIuMS45LTMuOSAyLjUtNS4zem0xOS41IDYwLjRIMzcuN3YtM2MuNy0uMSAxLjQtLjEgMi4xLS4yczEuMy0uMiAxLjctLjRjLjktLjMgMS41LS44IDEuOC0xLjQuMy0uNi41LTEuNC41LTIuNFY1MC40YzAtLjktLjItMS44LS42LTIuNS0uNC0uNy0xLTEuMy0xLjYtMS43LS41LS4zLTEuMi0uNi0yLjItLjlzLTEuOS0uNS0yLjctLjZ2LTNsMTkuOC0xLjEuNi42djMyLjFjMCAuOS4yIDEuNy42IDIuNC40LjcgMSAxLjIgMS43IDEuNS41LjIgMS4xLjUgMS44LjYuNi4yIDEuMy4zIDIgLjR2My4xeiIgZmlsbD0iI2ZmZiIvPjwvc3ZnPg==',
                    'filename_alt_text' => '',
                ]),
                'component' => [
                    'filename' => 'button-row',
                ],
            ],

            // Button row - configuration accordion
            'accordion-1' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-button-row',
                        'title' => 'Button row area configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-button-row',
                            'Data' => '{
"id": 0,
"columns": 3,
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'sectionClass' => '-mt-gutter-sm'
                ],
            ],

            // Spotlight row
            'spotlight_row' => [
                'data' => app(Spotlight::class)->create(1, false),
                'component' => [
                    'heading' => 'Spotlight',
                    'filename' => 'spotlight-row',
                    'showDescription' => true,
                    'sectionClass' => 'bg-gold-50 p-gutter rounded-sm'
                ],
            ],

            // Spotlight row - configuration accordion
            'accordion-8' => [
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
"sectionClass": "bg-gold-50 p-gutter rounded-sm",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'sectionClass' => '-mt-gutter-sm'
                ],
            ],

            // Additional content
            'promo-row-1' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'youtube_id' => '',
                    'relative_url' => '',
                    'link' => '',
                    'title' => 'Additional content (promo row)',
                    'description' => '<p>Example placement of an introductory paragraph describing the information laid out in the accordion below.</p><p>This is a separate promo group using the "content row" component. Below this is a different promo group with the accordion data and no component heading specified.</p>',
                    'excerpt' => '',
                ]),
                'component' => [
                    'filename' => 'promo-row',
                    'showExcerpt' => false,
                    'sectionClass' => 'mb-0',
                ],
            ],

            'accordion-99' => [
                'data' => app(GenericPromo::class)->create(4, false),
                'component' => [
                    'filename' => 'accordion',
                ],
            ],

            // Additional content - configuration accordion
            'accordion-3' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-additional-content',
                        'title' => 'Additional resources area configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-promo-row',
                            'Data' => '{
"id": 0,
"showExcerpt": false,
"sectionClass": "mb-0",
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-accordion',
                            'Data' => '{
"id": 0,
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'sectionClass' => '-mt-gutter-sm'
                ],
            ],

            // News section
            'heading-1' => [
                'data' => [
                    0 => [
                        'heading' => 'News',
                    ],
                ],
                'component' => [
                    'filename' => 'heading',
                ],
            ],

            'promo-column-1' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Featured article (promo column)',
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

            'news-column' => [
                'data' => app(ArticleComponent::class)->create(5, false),
                'meta' => app(ArticleMeta::class)->create(),
                'component' => [
                    'filename' => 'news-column',
                    'columnSpan' => 6,
                ],
            ],

            // News - configuration accordion
            'accordion-4' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-news',
                        'title' => 'News area configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-heading',
                            'Data' => '{
"heading": "News",
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-promo-row',
                            'Data' => '{
"id": 0,
"showExcerpt": false,
"gradientOverlay": true,
"columnSpan": 6,
}',
                        ],
                        'tr3' => [
                            'Page field' => 'modular-news-column',
                            'Data' => '{
"columnSpan": 6,
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'sectionClass' => '-mt-gutter-sm'
                ],
            ],

            // Events section
            'heading-2' => [
                'data' => [
                    0 => [
                        'heading' => 'Events',
                    ],
                ],
                'component' => [
                    'filename' => 'heading',
                ],
            ],

            'events-column' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'filename' => 'events-column',
                    'calendar_url' => '/myurl',
                    'columnSpan' => 7,
                ],
            ],

            'promo-column-2' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Featured event (promo column)',
                    'relative_url' => '/styleguide/image/600x600',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => '',
                    'filename' => 'promo-column',
                    'columnSpan' => 5,
                ],
            ],

            // Events- configuration accordion
            'accordion-5' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-events',
                        'title' => 'Events area configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-heading',
                            'Data' => '{
"heading": "Events",
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-events-column',
                            'Data' => '{
"columnSpan": 7,
}',
                        ],
                        'tr3' => [
                            'Page field' => 'modular-promo-row',
                            'Data' => '{
"id": 0,
"showExcerpt": false,
"columnSpan": 5,
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'sectionClass' => '-mt-gutter-sm'
                ],
            ],

            // Video promo column
            'promo-column-3' => [
                'data' => app(Video::class)->create(1, false),
                'component' => [
                    'heading' => 'Video promo column',
                    'filename' => 'promo-column',
                    'columnSpan' => 8,
                ],
            ],

            // Video buttons
            'button-column' => [
                'data' => app(Button::class)->create(4, false, [
                    'option' => 'Default',
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Button column',
                    'filename' => 'button-column',
                    'headingLevel' => 'h3',
                    'columnSpan' => 4,
                ],
            ],

            // Video - configuration accordion
            'accordion-6' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-video',
                        'title' => 'Video area configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-promo-column',
                            'Data' => '{
"id":0,
"heading":"Video promo column"
"columnSpan": 8,
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-button-column',
                            'Data' => '{
"id": 0,
"heading":"Button column"
"columnSpan": 4,
"headingLevel": "h3",
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'sectionClass' => '-mt-gutter-sm'
                ],
            ],

            // Catalog
            'catalog-1' => [
                'data' => app(GenericPromo::class)->create(6, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Catalog',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                ],
            ],

            // Catalog - configuration accordion
            'accordion-7' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component-config-catalog',
                        'title' => 'Catalog area configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-catalog-column',
                            'Data' => '{
"id":0,
"heading":"Video promo column"
"columnSpan": 8,
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                    'sectionClass' => '-mt-gutter-sm'
                ],
            ],
        ];

        $components = $this->components->componentClasses($components);
        $components = $this->components->componentStyles($components);

        // Assign components globally
        $request->data['base']['components'] = $components;

        if (!empty($request->data['base']['components'])) {
            // Set hero from components
            $hero = collect($request->data['base']['components'])->reject(function ($data, $component_name) {
                return !str_contains($component_name, 'hero');
            })->toArray();
        }

        if (!empty($hero)) {
            $hero_key = array_key_first($hero);

            $request->data['base']['hero'] = $request->data['base']['components'][$hero_key]['data'];

            unset($request->data['base']['components'][$hero_key]);

            config(['base.hero_full_controllers' => [$request->data['base']['page']['controller']]]);
        }
        return view('childpage', merge($request->data));
    }
}
