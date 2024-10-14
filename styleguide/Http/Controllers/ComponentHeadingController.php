<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Factories\GenericPromo;
use Factories\Event;

class ComponentHeadingController extends Controller
{
    /**
     * Display a page heading from a page field
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p>Add a page heading that spans an entire row. Suggested to use over two related columns, like an "Events" heading over a promo-column featured image, and an events-column. You would not use this when you can add a heading to an individual component.</p>
';

        $components = [
            'accordion' => [
                'data' => [
                    0 => [
                        'title' => 'Component configuration',
                        'promo_item_id' => 'componentConfiguration',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-heading-1',
                            'Data' => '{
"heading":"My heading",
"headingClass":"gold-divider text-green",
"headingLevel":"h3"
}',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                ],
            ],
            'heading-1' => [
                'data' => [
                    0 => [
                        'heading' => 'My example heading',
                    ],
                ],
                'component' => [
                    'filename' => 'heading',
                ],
            ],
            'events-column' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'filename' => 'events-column',
                    'calendar_url' => '/myurl'
                ],
            ],
            'promo-column-2' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Featured event (promo column)',
                    'filename_url' => '/styleguide/image/600x600',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => '',
                    'filename' => 'promo-column',
                    'gradientOverlay' => true,
                ],
            ],
        ];

        // Different data for h3 page
        if ($request->data['base']['page']['id'] === 122100200) {
            $components['heading-1']['data'][0]['heading'] = "My example h3";
            $components['heading-1']['component']['headingLevel'] = "h3";
            $components['heading-1']['component']['headingClass'] = "divider-gold text-green";
        }

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data, $components));
    }
}
