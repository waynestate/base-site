<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Spotlight;
use Factories\GenericPromo;

class ComponentSpotlightController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }

    /**
     * Article Listing Controller
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
';

        $components = [
            'accordion' => [
                'data' => [
                    0 => [
                        'title' => 'Component configuration',
                        'promo_item_id' => 'componentConfiguration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-spotlight-column-1</pre><pre>modular-spotlight-row-1',
                            'Data' => '{
"id":000000,
"heading":"Spotlight",
"config":"randomize|limit:1",
"singlePromoView":false,
"showDescription":false
}',
                        ],
                    ],
                    1 => [
                        'title' => 'Promotion group details',
                        'promo_item_id' => 'promotionGroupDetails',
                        'description' => '',
                        'table' => [
                            'Title' => 'Displays as a cited name below the quote.',
                            'Link' => 'Optional external link. Component flag "singlePromoView" sets the link to the individual promo item view.',
                            'Excerpt' => 'Main quote area by default. If component flag "showDescription" is set to true, excerpt can display underneath the name like a degree or job title. <br />
                            Accepts only these html entities: &ldquo; &rdquo; &lt;em&gt; &lt;strong&gt;',
                            'Description' => 'Can be used as the quote area if the component flag "showDescription" is set to true.',
                            'Filename' => 'Primary promo image, 600x600px or any square size. Other sizes will be centered to fit in the circle.',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                ],
            ],
            'spotlight-1' => [
                'data' => app(Spotlight::class)->create(1, false, [
                    'link' => '',
                    'relative_url' => '/styleguide/image/600x600',
                    'filename_url' => '/styleguide/image/600x600',
                ]),
                'component' => [
                    'heading' => 'Spotlight column',
                    'filename' => 'spotlight-column',
                    'showDescription' => true,
                ],
            ],
            'spotlight-2' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => $this->faker->name(),
                    'excerpt' => '&ldquo;' . $this->faker->text(200) . '&rdquo;',
                    'relative_url' => '/styleguide/image/600x600',
                    'filename_url' => '/styleguide/image/600x600',
                ]),
                'component' => [
                    'heading' => 'Spotlight row',
                    'filename' => 'spotlight-row',
                ],
            ],
        ];

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data));
    }
}
