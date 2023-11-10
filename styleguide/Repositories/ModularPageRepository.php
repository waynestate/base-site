<?php

namespace Styleguide\Repositories;

use App\Repositories\ModularPageRepository as Repository;
use Factories\GenericPromo;
use Factories\Button;
use Factories\HeroImage;
use Factories\Spotlight;
use Factories\Article;
use Factories\Event;

class ModularPageRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getModularComponents(array $data): array
    {
        $components = [
            'hero-1' => [
                'data' => app(HeroImage::class)->create(1, false),
                'component' => [
                    'heading' => 'Hero',
                    'filename' => 'hero',
                ],
            ],

            'catalog-1' => [
                'data' => app(GenericPromo::class)->create(4, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Catalog - 4 columns',
                    'filename' => 'catalog',
                    'columns' => '4',
                    'showDescription' => false,
                ],
            ],

            'content-row-1' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Content from promos'
                ]),
                'component' => [
                    'filename' => 'content-row',
                ],
            ],

            'accordion-1' => [
                'data' => app(GenericPromo::class)->create(4, false),
                'component' => [
                    'filename' => 'accordion',
                ],
            ],

            'image-column-1'=> [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Featured news (image column)',
                    'filename_url' => '/styleguide/image/770x434',
                ]),
                'component' => [
                    'heading' => '',
                    'filename' => 'image-column',
                ],
            ],

            'news-column' => [
                'data' => app(Article::class)->create(4, false),
                'component' => [
                    'heading' => 'News column',
                    'filename' => 'news-column',
                ],
            ],

            'news-row' => [
                'data' => app(Article::class)->create(4, false),
                'component' => [
                    'heading' => 'News row',
                    'filename' => 'news-row',
                ],
            ],

            'events-column' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Events column',
                    'filename' => 'events-column',
                    'cal_name' => 'main/'
                ],
            ],

            'image-column-2' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Featured event (image column)',
                    'filename_url' => '/styleguide/image/600x600',
                ]),
                'component' => [
                    'heading' => '',
                    'filename' => 'image-column',
                ],
            ],

            'events-row' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Events row',
                    'filename' => 'events-row',
                    'cal_name' => '/myurl'
                ],
            ],

            'catalog-2' => [
                'data' => app(GenericPromo::class)->create(2, false, [
                ]),
                'component' => [
                    'heading' => 'Catalog - 1 column',
                    'filename' => 'catalog',
                    'columns' => '1',
                    'showDescription' => false,
                ],
            ],

            'icons-column' => [
                'data' => app(GenericPromo::class)->create(4, false),
                'component' => [
                    'heading' => 'Icons column',
                    'filename' => 'icons-column',
                ],
            ],

            'button-column' => [
                'data' => app(Button::class)->create(4, false),
                'component' => [
                    'heading' => 'Button column',
                    'filename' => 'button-column',
                ],
            ],

            'button-row' => [
                'data' => app(Button::class)->create(4, false),
                'component' => [
                    'heading' => 'Button row',
                    'filename' => 'button-row',
                    'columns' => 4
                ],
            ],

            'spotlight-row' => [
                'data' => app(Spotlight::class)->create(1, false),
                'component' => [
                    'heading' => 'Spotlight',
                    'filename' => 'spotlight-row',
                ],
            ],

            'video-row' => [
                'data' => app(GenericPromo::class)->create(1, false),
                'component' => [
                    'heading' => 'Video',
                    'filename' => 'video-row',
                ],
            ],

            'video-column-1' => [
                'data' => app(GenericPromo::class)->create(1, false),
                'component' => [
                    'heading' => 'Video column 1',
                    'filename' => 'video-column',
                ],
            ],

            'video-column-2' => [
                'data' => app(GenericPromo::class)->create(1, false),
                'component' => [
                    'heading' => 'Video column 2',
                    'filename' => 'video-column',
                ],
            ],
        ];

        return $components;
    }
}
