<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Button;

class ComponentButtonsController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Display an example table stack.
     */
    public function index(Request $request): View
    {

        $request->data['base']['page']['content']['main'] = '
<p>This component serves as the buttons under the side menu and as button components on your page.</p>
';

        // Default button
        $default[1] = app(Button::class)->create(1, true, [
            'title' => 'Default button',
            'option' => 'Default',
        ]);

        // Default two lines
        $default[2] = app(Button::class)->create(1, true, [
            'title' => 'Two-line button',
            'option' => 'Default',
            'excerpt' => 'Excerpt text here',
        ]);

        // Default icon
        $default[3] = app(Button::class)->create(1, true, [
            'title' => 'Icon button',
            'option' => 'Default',
            'link' => '#.pdf',
            'filename_alt_text' => 'Example green icon',
            'icon' => true,
        ]);

        // Green button
        $green[1] = app(Button::class)->create(1, true, [
            'title' => 'Green button',
            'option' => 'Green',
            'link' => '#.pdf',
        ]);

        // Green two lines
        $green[2] = app(Button::class)->create(1, true, [
            'title' => 'Two-line button',
            'option' => 'Green',
            'excerpt' => 'Excerpt text here',
            'link' => '#.pdf',
        ]);

        // Green icon
        $green[3] = app(Button::class)->create(1, true, [
            'title' => 'Icon button',
            'option' => 'Green',
            'excerpt' => 'Excerpt text here',
            'link' => '#.pdf',
            'icon' => true,
        ]);

        // Image
        $image[1] = app(Button::class)->create(1, true, [
            'title' => 'Image',
            'option' => 'Image',
            'relative_url' => "/styleguide/image/600x218?text=Primary+image+only",
        ]);

        // PDF
        $image[2] = app(Button::class)->create(1, true, [
            'title' => 'PDF',
            'option' => 'Image',
            'relative_url' => "/styleguide/image/600x218?text=Image+linking+to+a+pdf",
            'link' => '#.pdf',
        ]);

        // SVG overlay
        $image[3] = app(Button::class)->create(1, true, [
            'title' => 'SVG overlay on dark background',
            'option' => 'Image',
            'overlay' => true,
        ]);

        // Use them as components
        $components = [
            'accordion' => [
                'data' => [
                    2 => [
                        'promo_item_id' => 'componentConfiguration',
                        'title' => 'Component configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-button-column-1',
                            'Data' => '{
"id":000000,
"heading":"Buttons",
"config":"limit:3"
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-button-row-1',
                            'Data' => '{
"id":000000,
"heading":"Buttons",
"config":"limit:3",
"columns":3
}',
                        ],
                    ],
                    1 => [
                        'promo_item_id' => 'promotionGroupDetails',
                        'title' => 'Promotion group details',
                        'description' => '',
                        'table' => [
                            'Title' => 'Text to appear on the button.',
                            'Link' => 'Your URL. When linking to a pdf, "(pdf)" is added automatically.',
                            'Excerpt' => 'Add a 2-3 word second line of text.',
                            'Options' => 'Default: Default, Green, Image, Green gradient',
                            'Primary image' => 'Icons: 40x40px PNG, SVG <br /> Images: 600x218px JPG, PNG recommended with descriptive alternative text. <br /> Text within the image is not allowed; it cannot maintain readability when scaled.',
                            'Secondary image' => 'SVG overlay image of the same dimensions as the primary image. <br /> Text can be used within the SVG because it is scalable. You must provide enough contrast between the background and overlay image to meet accessibility standards. Secondary image alternative text not used.',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                ],
            ],
            'button_row_1' => [
                'data' => app(Button::class)->create(3, false, [
                    'option' => 'Green',
                ]),
                'component' => [
                    'heading' => 'Button row',
                    'filename' => 'button-row',
                    'columns' => 3
                ],
            ],
            'button_column_1' => [
                'data' => app(Button::class)->create(3, false, [
                    'option' => 'Green',
                ]),
                'component' => [
                    'heading' => 'Button column',
                    'filename' => 'button-column',
                ],
            ],
            'button_column_2' => [
                'data' => $default,
                'component' => [
                    'heading' => 'Default buttons',
                    'filename' => 'button-column',
                ],
            ],
            'button_column_3' => [
                'data' => $green,
                'component' => [
                    'heading' => 'Green buttons',
                    'filename' => 'button-column',
                ],
            ],
            'button_column_4' => [
                'data' => $image,
                'component' => [
                    'heading' => 'Image buttons',
                    'filename' => 'button-column',
                ],
            ],
        ];

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('styleguide-component-buttons', merge($request->data, $components));
    }
}
