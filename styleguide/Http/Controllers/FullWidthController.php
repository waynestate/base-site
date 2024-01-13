<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\HeroImage;
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
                ]),
                'component' => [
                    'filename' => 'hero',
                ],
            ],
            'button_row' => [
                'data' => app(Button::class)->create(3, false, [
                    'option' => 'green',
                    'excerpt' => '',
                    'relative_url' => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cGF0aCBkPSJNNTAgMi41QzIzLjggMi41IDIuNSAyMy44IDIuNSA1MFMyMy44IDk3LjUgNTAgOTcuNSA5Ny41IDc2LjIgOTcuNSA1MCA3Ni4yIDIuNSA1MCAyLjV6bS02LjIgMTguNGMxLjYtMS41IDMuNS0yLjIgNS42LTIuMiAyLjIgMCA0LjEuNyA1LjYgMi4yIDEuNiAxLjUgMi4zIDMuMiAyLjMgNS4zIDAgMi0uOCAzLjgtMi40IDUuMi0xLjYgMS40LTMuNCAyLjItNS42IDIuMi0yLjIgMC00LjEtLjctNS42LTIuMi0xLjYtMS40LTIuNC0zLjItMi40LTUuMi4xLTIuMS45LTMuOSAyLjUtNS4zem0xOS41IDYwLjRIMzcuN3YtM2MuNy0uMSAxLjQtLjEgMi4xLS4yczEuMy0uMiAxLjctLjRjLjktLjMgMS41LS44IDEuOC0xLjQuMy0uNi41LTEuNC41LTIuNFY1MC40YzAtLjktLjItMS44LS42LTIuNS0uNC0uNy0xLTEuMy0xLjYtMS43LS41LS4zLTEuMi0uNi0yLjItLjlzLTEuOS0uNS0yLjctLjZ2LTNsMTkuOC0xLjEuNi42djMyLjFjMCAuOS4yIDEuNy42IDIuNC40LjcgMSAxLjIgMS43IDEuNS41LjIgMS4xLjUgMS44LjYuNi4yIDEuMy4zIDIgLjR2My4xeiIgZmlsbD0iI2ZmZiIvPjwvc3ZnPg==',
                    'filename_alt_text' => '',
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
                    'heading' => 'Base news',
                    'filename' => 'news-row',
                ],
            ],

            'events_column' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Base events',
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

            'spotlight' => [
                'data' => app(Spotlight::class)->create(2, false),
                'component' => [
                    'heading' => 'Spotlight',
                    'filename' => 'spotlight-row',
                    'showDescription' => true,
                ],
            ],

            'promo_row_1' => [
                'data' => app(GenericPromo::class)->create(2, false),
                'component' => [
                    'heading' => 'Promo row with alternating image position',
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
                    'filename' => 'promo-column',
                    'columns' => '3',
                    'showDescription' => false
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

        return view('styleguide-fullwidth', merge($request->data, $this->faker, $components));
    }
}
