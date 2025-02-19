<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;
use Factories\ArticleMeta;

class FullWidth extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/fullwidth';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        $page = app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'FullWidthController',
                'title' => 'Full width template',
                'id' => 101109,
                'content' => [
                    'main' => '<p>'.$this->faker->paragraph(8).'</p>'
                ],
            ],
            'site' => [
                'subsite-folder' => 'styleguide/',
                'news' => [
                    'application_id' => 1,
                ],
                'events' => [
                    'path' => 'main'
                ],
            ],
        ]);

        $components = [
            // TODO make this work and  add it to styleguide menu
            /*
            'modular-layout-config' => [
                'component' => [
                    'layoutClass' => '',
                    'pageClass' => '',
                ],
            ], 
             */
            'modular-hero' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'hero',
                    'heroClass' => 'full-width-styleguide-hero', //TODO make this work
                ],
            ],
            'modular-spotlight' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'spotlight',
                    'heading' => 'Spotlight',
                    'showDescription' => true,
                    'sectionClass' => 'bg-gold-100 py-10',
                ],
            ],
            'modular-icons-row-1' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'icons-row',
                    'limit' => 6, // TODO extract this from 'config' or implode specified values
                    'columns' => 2,
                    'backgroundImageUrl' => '/styleguide/image/3200x1140',
                ],
            ],
            'modular-catalog-3' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'catalog',
                    'limit' => 6,
                    'heading' => 'Catalog',
                    'columns' => '3',
                    'showDescription' => false,
                    'sectionClass' => 'bg-gray-100 py-10',
                ],
            ],

            'modular-promo-row' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'content-row',
                    'heading' => 'Content row',
                ],
            ],

            // TODO why is this breaking
            /*
            'modular-heading-1' => [
                'component' => [
                    'filename' => 'heading',
                    'heading' => 'heading',
                ],
            ],
             */

            'modular-promo-column-2' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'promo-column',
                    'heading' => '',
                    'gradientOverlay' => true,
                    'columnSpan' => '6',
                ],
            ],

            'modular-accordion-1' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'accordion',
                    'columnSpan' => '6',
                ],
            ],

            'modular-news_row' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'news-row',
                    'heading' => 'Featured news',
                    'sectionClass' => 'bg-gray-100 py-10',
                ],
                'meta' => app(ArticleMeta::class)->create(),
            ],

            'modular-promo-column-1' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'promo-column',
                    'heading' => '',
                    'gradientOverlay' => true,
                    'columnSpan' => '5',
                ],
            ],

            'modular-events-column' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'events-column',
                    'heading' => 'Special events',
                    'columnSpan' => '7'
                ],
            ],

            'modular-icons-top-row-2' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'icons-top-row',
                    'heading' => 'Icons top row',
                    'limit' => 5,
                    'columns' => 5,
                    'headingClass' => 'divider-gold mb-8',
                ],
            ],

            'modular-spotlight-row' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'spotlight-row',
                    'heading' => 'Spotlight',
                    'showDescription' => true,
                    'sectionClass' => 'bg-gold-100 py-10'
                ],
            ],

            'modular-catalog-2' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'catalog',
                    'heading' => 'One column catalog',
                    'limit' => 2,
                    'columns' => '1',
                    'showDescription' => false,
                    'imageSize' => 'small',
                    'columnSpan' => 8,
                ],
            ],

            'modular-button-column' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'button-column',
                    'limit' => 3,
                    'heading' => 'Resources: Button column',
                    'columnSpan' => '4',
                    'headingLevel' => 'h4'
                ],
            ],

            'modular-promo-row-1' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'promo-row',
                    'limit' => 2,
                    'heading' => 'Promo row alternate',
                    'imagePosition' => 'alternate',
                    'sectionClass' => 'bg-gray-100 py-10',
                ],
            ],

            'modular-promo-row-2' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'promo-row',
                    'heading' => 'Content row',
                    'columnSpan' => 10,
                    'headingClass' => 'divider-gold',
                    'showImages' => false, // TODO
                ],
            ],

            'modular-button-row-1' => [
                'component' => [
                    'id' => $this->faker->numberBetween(1000, 10000),
                    'filename' => 'button-row',
                    'heading' => 'Button row',
                    'limit' => 3,
                    'sectionClass' => 'bg-gold-100 py-10',
                    'backgroundImageUrl' => '/styleguide/image/3200x400',
                    'sectionStyle' => 'padding-top:6rem; padding-bottom: 6rem;',
                ],
            ],
        ];

        // TODO move to modular repo
        // Array of options to json encode
        foreach ($components as $componentName => $componentData) {
            $page['data'][$componentName] = json_encode($componentData['component']);
        }

        $page['_components'] = $components;

        return $page;
    }
}
