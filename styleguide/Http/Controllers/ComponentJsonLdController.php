<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class ComponentJsonLdController extends Controller
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
     * Display an example JSON-LD metadata page.
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p>Add structured data to any page by including a <code>meta-json-ld</code> key in the <code>data</code> array of the page\'s JSON file. The value must be a valid JSON string. Invalid JSON is silently ignored. Not all pages require this field.</p>
<p>Inspect the <code>&lt;head&gt;</code> of this page to see the rendered <code>&lt;script type="application/ld+json"&gt;</code> tag.</p>
';

        $components = [
            'accordion' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component_config',
                        'title' => 'Component configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'meta-json-ld',
                            'Data' => '{
"@context": "https://schema.org",
"@type": "Person",
"name": "' . $this->faker->firstName() . ' ' . $this->faker->lastName() . '"
}',
                        ],
                    ],
                    1 => [
                        'promo_item_id' => 'promo_details',
                        'title' => 'Configuration details',
                        'description' => '',
                        'table' => [
                            '@context' => 'Required. The schema context URL.',
                            '@type' => 'Required. The schema type (e.g. Person, Organization, Event).',
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
