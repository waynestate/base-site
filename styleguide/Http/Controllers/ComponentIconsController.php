<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Icon;

class ComponentIconsController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Article Listing Controller
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p>Present a list of promotional items accompanied by icons, offering a visually appealing and informative display.</p>
';

        $components = [
            'accordion' => [
                'data' => [
                    0 => [
                        'title' => 'Component configuration',
                        'promo_item_id' => 'componentConfiguration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-icons-column-1',
                            'Data' => '{
"id":000000,
"heading":"Icons column"
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-icons-row-1',
                            'Data' => '{
"id":000000,
"heading":"Icons row",
"columns":2
}',
                        ],
                        'tr3' => [
                            'Page field' => 'modular-icons-top-row-1',
                            'Data' => '{
"id":000000,
"heading":"Icons top row",
"columns":4,
"showDescription":true
}',
                        ],
                    ],
                    1 => [
                        'title' => 'Promotion group details',
                        'promo_item_id' => 'promotionGroupDetails',
                        'description' => '',
                        'table' => [
                            'Title' => 'Bold text.',
                            'Link' => 'Optional external link. Component flag "singlePromoView" sets the link to the individual promo item view.',
                            'Excerpt' => 'Optional smaller text under the title.',
                            'Description' => 'Optional smaller text under the title and/or excerpt. You might use this area on a singe promo view page and hide it from the component.',
                            'Primary image' => 'Minimum width of 160px svg, png, jpg.',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                ],
            ],
            'icons-column-1' => [
                'data' => app(Icon::class)->create(4, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Icons column',
                    'filename' => 'icons-column',
                ],
            ],
            'icons-row-1' => [
                'data' => app(Icon::class)->create(4, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Icons row',
                    'filename' => 'icons-row',
                ],
            ],
            'icons-top-row-1' => [
                'data' => app(Icon::class)->create(4, false, [
                    'excerpt' => '',
                    'link' => '',
                ]),
                'component' => [
                    'heading' => 'Icons top row',
                    'filename' => 'icons-top-row',
                    'columns' => 4
                ],
            ],
        ];

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data));
    }
}
