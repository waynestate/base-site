<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Factories\GenericPromo;
use Factories\Spotlight;
use Factories\Article;
use Factories\Event;

class ModularDocsController extends Controller
{
    /**
     * Display the banner at the top of the page.
     */
    public function index(Request $request): View
    {
        $components = [
            'catalog_1' => [
                'data' => app(GenericPromo::class)->create(7, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Four-column catalog',
                    'filename' => 'catalog',
                    'columns' => '4',
                    'showDescription' => false,
                ],
            ],

            'catalog_2' => [
                'data' => app(GenericPromo::class)->create(2, false, [
                ]),
                'component' => [
                    'heading' => 'One-column catalog',
                    'filename' => 'catalog',
                    'columns' => '1',
                    'showDescription' => false,
                ],
            ],

            'content_row_1' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Content from promos'
                ]),
                'component' => [
                    'filename' => 'content-row',
                ],
            ],

            'accordion_1' => [
                'data' => app(GenericPromo::class)->create(4, false),
                'component' => [
                    'filename' => 'accordion',
                    'heading' => 'Accordion',
                ],
            ],

            'image_column_1'=> [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Featured news (image column)',
                    'filename_url' => '/styleguide/image/770x434',
                ]),
                'component' => [
                    'heading' => '',
                    'filename' => 'image-column',
                ],
            ],

            'news_column' => [
                'data' => app(Article::class)->create(3, false),
                'component' => [
                    'heading' => 'Base news',
                    'filename' => 'news-column',
                ],
            ],

            'news_row_1' => [
                'data' => app(Article::class)->create(4, false),
                'component' => [
                    'heading' => 'Base news',
                    'filename' => 'news-column',
                ],
            ],

            'events_column_1' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'heading' => 'Base events',
                    'filename' => 'events-column',
                    'calendar_url' => '/myurl'
                ],
            ],

            'image_column_2' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Featured event (image column)',
                    'filename_url' => '/styleguide/image/600x600',
                ]),
                'component' => [
                    'heading' => '',
                    'filename' => 'image-column',
                ],
            ],

            'icons_column' => [
                'data' => app(GenericPromo::class)->create(4, false),
                'component' => [
                    'heading' => 'Icons column',
                    'filename' => 'icons-column',
                ],
            ],

            'button_column' => [
                'data' => app(GenericPromo::class)->create(4, false),
                'component' => [
                    'heading' => 'Button column',
                    'filename' => 'button-column',
                ],
            ],

            'spotlight' => [
                'data' => app(Spotlight::class)->create(1, false),
                'component' => [
                    'heading' => 'Spotlight',
                    'filename' => 'spotlight',
                ],
            ],

            'video_row' => [
                'data' => app(GenericPromo::class)->create(1, false),
                'component' => [
                    'heading' => 'Video',
                    'filename' => 'video-row',
                ],
            ],

            'video_column_1' => [
                'data' => app(GenericPromo::class)->create(1, false),
                'component' => [
                    'heading' => 'Video column 1',
                    'filename' => 'video-column',
                ],
            ],

            'video_column_2' => [
                'data' => app(GenericPromo::class)->create(1, false),
                'component' => [
                    'heading' => 'Video column 2',
                    'filename' => 'video-column',
                ],
            ],
        ];

        return view('styleguide-modular-docs', merge($request->data, $components));
    }
}
