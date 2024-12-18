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
use Factories\ContentPromo;
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

            'button_row_1' => [
                'data' => app(Button::class)->create(3, false, [
                ]),
                'component' => [
                    'heading' => 'Button row',
                    'filename' => 'button-row',
                ],
            ],

            'icons_row_1' => [
                'data' => app(Icon::class)->create(6, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Lead in statement',
                    'filename' => 'icons-row',
                    'columns' => 2,
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

            'events_column' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Special events',
                    'filename' => 'events-column',
                ],
            ],

            'promo_row_1' => [
                'data' => app(ContentPromo::class)->create(2, false),
                'component' => [
                    'heading' => 'Something to remember',
                    'filename' => 'promo-row',
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

            'promo_row_2' => [
                'data' => app(ContentPromo::class)->create(2, false, [
                    'relative_url' => '',
                    'filename_url' => '',
                ]),
                'component' => [
                    'heading' => 'Call to action statement',
                    'filename' => 'promo-row',
                ],
            ],

            'catalog_1' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Highlights',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                    'sectionClass' => 'bg-gray-100 py-8'
                ],
            ],

            /*
            'accordion_1' => [
                'data' => app(GenericPromo::class)->create(4, false),
                'component' => [
                    'filename' => 'accordion',
                ],
            ],
             */

            'news_row' => [
                'data' => app(Article::class)->create(4, false),
                'component' => [
                    'heading' => 'Featured news',
                    'filename' => 'news-row',
                    'sectionClass' => 'bg-gray-100'
                ],
            ],

            'spotlight_column' => [
                'data' => app(Spotlight::class)->create(1, false),
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

        $request->data['base']['components'] = $components;
        //dump($request->data['base']['components']);

        return view('childpage', merge($request->data, $this->faker, $components, $heroClass));
    }
}
