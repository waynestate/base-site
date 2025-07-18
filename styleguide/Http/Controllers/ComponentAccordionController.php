<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Factories\AccordionItems;

class ComponentAccordionController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(
        ModularPageRepositoryContract $components
    ) {
        $this->components = $components;
    }

    /**
     * Display an example accordion.
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p>Use accordions on pages where a person needs to scan a number of headings and choosing a single item to get information.</p>
';

        $components = [
            'accordion' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'component_config',
                        'title' => 'Component configuration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-accordion-1',
                            'Data' => '{
"id":000000,
"heading":"My accordion"
}',
                        ],
                    ],
                    1 => [
                        'promo_item_id' => 'promo_details',
                        'title' => 'Promo group details',
                        'description' => '',
                        'table' => [
                            'Title' => 'Text on closed accordion',
                            'Description' => 'Content when the accordion is clicked open',
                            'Primary image' => 'Optional image',
                            'Excerpt' => 'Image caption',
                            'Option' => 'Image orientation: Left, Center, Right(default)',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                ],
            ],
            'accordion-2' => [
                'data' => app(AccordionItems::class)->create(4, false),
                'component' => [
                    'heading' => 'My accordion',
                    'filename' => 'accordion',
                ],
            ],
            'accordion-3' => [
                'data' => app(AccordionItems::class)->create(3, false),
                'component' => [
                    'heading' => 'My second accordion',
                    'filename' => 'accordion',
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
