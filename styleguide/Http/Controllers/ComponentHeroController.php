<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class ComponentHeroController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(
        Factory $faker,
        ModularPageRepositoryContract $components
    ) {
        $this->faker['faker'] = $faker->create();
        $this->components = $components;
    }

    /**
     * Hero Controller
     */
    public function index(Request $request): View
    {
        $components = [
            'accordion' => [
                'data' => [
                    0 => [
                        'title' => 'Component configuration',
                        'promo_item_id' => 'component_config',
                        'description' => '<p>Note: Any limit above 1 will enable the carousel.</p>',
                        'tr1' => [
                            'Page field' => 'modular-hero-1',
                            'Data' => '{
"id":0000,
"config":"randomize|limit:1"
}',
                        ],
                    ],
                    1 => [
                        'title' => 'Promotion group details',
                        'promo_item_id' => 'promo_details',
                        'description' => '',
                        'table' => [
                            'Title' => 'Displayed using options "Text overlay," "Logo overlay" and will become a link if link field is used.',
                            'Link' => 'URL',
                            'Description' => 'Formattable text. If the link field is set, description links will be stripped out.',
                            'Filename' => '1600x580px or 3200x1160px saved at low quality',
                            'Secondary image' => 'SVG Overlay: 1600x580px or 3200x1160px svg<br />Logo overlay: >600px jpg, png',
                            'Options' => 'Banner small, Banner large, Text overlay, Half, Logo overlay, SVG overlay',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                ],
            ],
        ];

        $components = $this->components->componentClasses($components);
        $components = $this->components->componentStyles($components);

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data));
    }
}
