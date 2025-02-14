<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Contracts\Repositories\ModularPageRepositoryContract;
use Faker\Factory;
use Factories\AccordionItems;
use Factories\ArticleMeta;
use Factories\ArticleComponent;
use Factories\Button;
use Factories\Event;
use Factories\GenericPromo;
use Factories\HeroImage;
use Factories\Icon;
use Factories\Spotlight;

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
     * Display the full width template.
     */
    public function index(Request $request): View
    {
        $request->data['base']['show_site_menu'] = false;

        $components = [
            'hero' => [
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
                ],
            ],

            'catalog_3' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'relative_url' => '/styleguide/image/600x450',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Catalog',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                    'sectionClass' => 'bg-gray-100 py-10',
                ],
            ],

            'promo-row' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Content row',
                    'description' => '<p>Example placement of an introductory paragraph describing the information laid out in the accordion below.</p><p>This is a separate promo group using the "content row" component. Below this is a different promo group with the accordion data and no component heading specified.</p>',
                ]),
                'component' => [
                    'filename' => 'content-row',
                ],
            ],

            'heading-1' => [
                'data' => [
                    0 => [
                        'heading' => 'My example heading',
                    ],
                ],
                'component' => [
                    'filename' => 'heading',
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
                'data' => app(AccordionItems::class)->create(4, false),
                'component' => [
                    'filename' => 'accordion',
                    'columnSpan' => '6',
                ],
            ],

            'news_row' => [
                'data' => app(ArticleComponent::class)->create(4, false),
                'meta' => app(ArticleMeta::class)->create(),
                'component' => [
                    'heading' => 'Featured news',
                    'filename' => 'news-row',
                    'sectionClass' => 'bg-gray-100 py-10',
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
                    'columnSpan' => '5',
                ],
            ],

            'events_column' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Special events',
                    'filename' => 'events-column',
                    'columnSpan' => '7'
                ],
            ],

            'icons_row_2' => [
                'data' => app(Icon::class)->create(5, false, [
                    'link' => '',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Icons top row',
                    'filename' => 'icons-top-row',
                    'columns' => 5,
                    'headingClass' => 'divider-gold mb-8',
                ],
            ],

            'spotlight_row' => [
                'data' => app(Spotlight::class)->create(1, false),
                'component' => [
                    'heading' => 'Spotlight',
                    'filename' => 'spotlight-row',
                    'showDescription' => true,
                    'sectionClass' => 'bg-gold-100 py-10'
                ],
            ],

            'catalog_2' => [
                'data' => app(GenericPromo::class)->create(2, false, [
                ]),
                'component' => [
                    'heading' => 'One column catalog',
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
                    'heading' => 'Resrouces: Button column',
                    'filename' => 'button-column',
                    'columnSpan' => '4',
                    'headingLevel' => 'h4'
                ],
            ],

            'promo_row_1' => [
                'data' => app(GenericPromo::class)->create(2, false),
                'component' => [
                    'heading' => 'Promo row alternate',
                    'filename' => 'promo-row',
                    'imagePosition' => 'alternate',
                    'sectionClass' => 'bg-gray-100 py-10',
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
                    'columnSpan' => 10,
                    'headingClass' => 'divider-gold',
                ],
            ],

            'button_row_1' => [
                'data' => app(Button::class)->create(3, false, [
                ]),
                'component' => [
                    'heading' => 'Button row',
                    'filename' => 'button-row',
                    'sectionClass' => 'bg-gold-100 py-10',
                    'backgroundImageUrl' => '/styleguide/image/3200x400',
                    'sectionStyle' => 'padding-top:6rem; padding-bottom: 6rem;',
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
