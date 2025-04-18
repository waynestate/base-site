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
    )
    {
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

            'icons_row_1' => [
                'data' => app(Icon::class)->create(6, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'filename' => 'icons-row',
                    'columns' => 2,
                    'backgroundImageUrl' => '/styleguide/image/3200x1140',
                    'heading' => 'Icons row',
                    'sectionClass' => 'mt-gutter-lg py-gutter-lg',
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

            'catalog_1' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Three column catalog',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                    'sectionClass' => 'py-gutter-lg bg-gray-100',
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
                    'columnSpan' => '6',
                ],
            ],

            'accordion_1' => [
                'data' => app(GenericPromo::class)->create(4, false),
                'component' => [
                    'filename' => 'accordion',
                    'columnSpan' => '6',
                    'sectionClass' => 'end',
                ],
            ],

            'news_row' => [
                'data' => app(ArticleComponent::class)->create(4, false),
                'meta' => app(ArticleMeta::class)->create(),
                'component' => [
                    'heading' => 'Featured news',
                    'filename' => 'news-row',
                    'sectionClass' => 'bg-gray-100 py-gutter-lg',
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
                    'columnSpan' => 5,
                ],
            ],

            'events_column' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Special events',
                    'filename' => 'events-column',
                    'columnSpan' => 7,
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
                    'columnSpan' => 8,
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
                    'columnSpan' => 4,
                ],
            ],

            'spotlight_row' => [
                'data' => app(Spotlight::class)->create(1, false),
                'component' => [
                    'heading' => 'Spotlight',
                    'filename' => 'spotlight-column',
                    'showDescription' => true,
                    'sectionClass' => 'bg-gold-100 py-gutter-lg'
                ],
            ],

            'promo_row_1' => [
                'data' => app(GenericPromo::class)->create(2, false),
                'component' => [
                    'heading' => 'Featured section',
                    'filename' => 'promo-row',
                    'imagePosition' => 'alternate',
                    'columnSpan' => 10,
                    'sectionClass' => 'end'
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
                    'heading' => 'Promo row',
                    'columns' => '2',
                ],
            ],

            'button_row_1' => [
                'data' => app(Button::class)->create(3, false, [
                ]),
                'component' => [
                    'heading' => 'Button row with background image',
                    'filename' => 'button-row',
                    'backgroundImageUrl' => '/styleguide/image/3200x1140',
                    'sectionClass' => 'py-gutter-xl'
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
