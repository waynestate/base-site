<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class ComponentPageConfigController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(
        Factory $faker,
        ModularPageRepositoryContract $components
    ) {
        $this->faker = $faker->create();
        $this->components = $components;
    }

    /**
     * Article Listing Controller
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p class="text-lg">Provides customization options for any childpage template. True is default; you only need to add configuration options that you want to set to false.</p>
            ';

        $components = [
            'accordion' => [
                'data' => [
                    2 => [
                        'promo_item_id' => 'component_config',
                        'title' => 'Component configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-page-config',
                            'Data' => '{
"showPageMenu": false,
"showBreadcrumbs": false,
"showPageTitle": false,
"pageClass": "custom-class",
}',
                        ],
                    ],
                    1 => [
                        'promo_item_id' => 'promo_details',
                        'title' => 'Configuration details',
                        'description' => '',
                        'table' => [
                            'showPageMenu' => 'false; hide left menu.',
                            'showBreadcrumbs' => 'false; hide breadcrumbs.',
                            'showPageTitle' => 'false; visually hide the page title.',
                            'pageClass' => 'Add a class to the body of the page.',
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
