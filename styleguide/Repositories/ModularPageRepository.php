<?php

namespace Styleguide\Repositories;

use App\Repositories\ModularPageRepository as Repository;
use Factories\GenericPromo;
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
        $components['catalog-1'] = [
            'data' => app(GenericPromo::class)->create(4, false, [
                'description' => '',
            ]),
            'component' => [
                'heading' => 'Catalog - 4 columns',
                'filename' => 'catalog',
                'columns' => '4',
                'showDescription' => false,
            ],
        ];

        $components['content-row-1'] = [
            'data' => app(GenericPromo::class)->create(1, false, [
                'title' => 'Content from promos'
            ]),
            'component' => [
                'filename' => 'content-row',
            ],
        ];

        $components['accordion-1'] = [
            'data' => app(GenericPromo::class)->create(4, false),
            'component' => [
                'filename' => 'accordion',
            ],
        ];

        $components['image-column-1'] = [
            'data' => app(GenericPromo::class)->create(1, false, [
                'title' => 'Featured news (image column)',
                'filename_url' => '/styleguide/image/770x434',
            ]),
            'component' => [
                'heading' => '',
                'filename' => 'image-column',
            ],
        ];

        $components['news-column'] = [
            'data' => app(Article::class)->create(3, false),
            'component' => [
                'heading' => 'Base news',
                'filename' => 'news-column',
            ],
        ];

        $components['events-column'] = [
            'data' => app(Event::class)->create(4, false),
            'component' => [
                'heading' => 'Base events',
                'filename' => 'events-column',
            ],
        ];

        $components['image-column-2'] = [
            'data' => app(GenericPromo::class)->create(1, false, [
                'title' => 'Featured event (image column)',
                'filename_url' => '/styleguide/image/600x600',
            ]),
            'component' => [
                'heading' => '',
                'filename' => 'image-column',
            ],
        ];

        $components['catalog-2'] = [
            'data' => app(GenericPromo::class)->create(2, false, [
            ]),
            'component' => [
                'heading' => 'Catalog - 1 column',
                'filename' => 'catalog',
                'columns' => '1',
                'showDescription' => false,
            ],
        ];

        $components['icons-column'] = [
            'data' => app(GenericPromo::class)->create(4, false),
            'component' => [
                'heading' => 'Icons column',
                'filename' => 'icons-column',
            ],
        ];

        $components['button-column'] = [
            'data' => app(GenericPromo::class)->create(4, false),
            'component' => [
                'heading' => 'Button column',
                'filename' => 'button-column',
            ],
        ];

        $components['spotlight'] = [
            'data' => app(Spotlight::class)->create(1, false),
            'component' => [
                'heading' => 'Spotlight',
                'filename' => 'spotlight',
            ],
        ];

        $components['video-row'] = [
            'data' => app(GenericPromo::class)->create(1, false),
            'component' => [
                'heading' => 'Video',
                'filename' => 'video-row',
            ],
        ];

        $components['video-column-1'] = [
            'data' => app(GenericPromo::class)->create(1, false),
            'component' => [
                'heading' => 'Video column 1',
                'filename' => 'video-column',
            ],
        ];

        $components['video-column-2'] = [
            'data' => app(GenericPromo::class)->create(1, false),
            'component' => [
                'heading' => 'Video column 2',
                'filename' => 'video-column',
            ],
        ];

        return $components;
    }
}
