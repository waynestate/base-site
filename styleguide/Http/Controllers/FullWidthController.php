<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\HeroImage;
use Factories\Icon;
use Factories\Spotlight;
use Factories\Button;
use Factories\GenericPromo;
use Factories\Article;
use Factories\Event;

class FullWidthController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
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

            'icons_row_1' => [
                'data' => app(Icon::class)->create(6, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'filename' => 'icons-row',
                    'columns' => 2,
                ],
            ],

            'icons_row_2' => [
                'data' => app(Icon::class)->create(4, false, [
                    'link' => '',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Facts',
                    'filename' => 'icons-top-row',
                    'columns' => 4,
                ],
            ],

            'button_row_1' => [
                'data' => app(Button::class)->create(3, false, [
                ]),
                'component' => [
                    'heading' => 'Button row',
                    'filename' => 'button-row',
                ],
            ],

            'catalog_1' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Three column catalog',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                ],
            ],

            'content_row_1' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Content row',
                    'description' => '<p>Example placement of an introductory paragraph describing the information laid out in the accordion below.</p><p>This is a separate promo group using the "content row" component. Below this is a different promo group with the accordion data and no component heading specified.</p>',
                ]),
                'component' => [
                    'filename' => 'content-row',
                ],
            ],

            'accordion_1' => [
                'data' => app(GenericPromo::class)->create(4, false),
                'component' => [
                    'filename' => 'accordion',
                ],
            ],

            'promo_column_2' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Featured promo (promo column)',
                    'relative_url' => '/styleguide/image/770x434',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => '',
                    'filename' => 'promo-column',
                    'gradientOverlay' => true,
                ],
            ],

            'news_row' => [
                'data' => app(Article::class)->create(4, false),
                'component' => [
                    'heading' => 'Featured news',
                    'filename' => 'news-row',
                ],
            ],

            'events_column' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Special events',
                    'filename' => 'events-column',
                    'calendar_url' => '/myurl'
                ],
            ],

            'promo_column_1' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Featured event (promo column)',
                    'relative_url' => '/styleguide/image/600x600',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => '',
                    'filename' => 'promo-column',
                    'gradientOverlay' => true,
                ],
            ],

            'catalog_2' => [
                'data' => app(GenericPromo::class)->create(2, false, [
                ]),
                'component' => [
                    'heading' => 'Single column catalog',
                    'filename' => 'catalog',
                    'columns' => '1',
                    'showDescription' => false,
                    'imageSize' => 'small',
                ],
            ],

            'spotlight_column' => [
                'data' => app(Spotlight::class)->create(2, false),
                'component' => [
                    'heading' => 'Spotlight',
                    'filename' => 'spotlight-column',
                    'showDescription' => true,
                ],
            ],

            'promo_row_1' => [
                'data' => app(GenericPromo::class)->create(2, false),
                'component' => [
                    'heading' => 'Featured section',
                    'filename' => 'promo-row',
                    'imagePosition' => 'alternate',
                ],
            ],

            'promo_column_3' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'relative_url' => '/styleguide/image/600x450',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Highlights',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                ],
            ],

            'button_column' => [
                'data' => app(Button::class)->create(4, false, [
                    'option' => 'Default',
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Button column',
                    'filename' => 'button-column',
                ],
            ],

            'promo_row_2' => [
                'data' => app(GenericPromo::class)->create(2, false, [
                    'relative_url' => '',
                    'link' => '',
                    'excerpt' => '',
                    'youtube_id' => '',
                    'description' => '<p>'.$this->faker['faker']->paragraph(13).'</p><p>'.$this->faker['faker']->paragraph(13).'</p>',
                ]),
                'component' => [
                    'filename' => 'promo-row',
                    'columns' => '2',
                ],
            ],
        ];

        if(!empty($components)) {
            // Set hero from components
            $hero = collect($components)->reject(function ($data, $component_name) {
                return !str_contains($component_name, 'hero');
            })->toArray();
        }

        if(!empty($hero)) {
            $hero_key = array_key_first($hero);

            $request->data['base']['hero'] = $components[$hero_key]['data'];

            unset($components[$hero_key]);

            config(['base.hero_full_controllers' => ['ChildpageWithComponentsController']]);
        }

        $heroClass['heroClass'] = 'full-width-styleguide-hero';

        return view('styleguide-fullwidth', merge($request->data, $this->faker, $components, $heroClass));
    }
}
