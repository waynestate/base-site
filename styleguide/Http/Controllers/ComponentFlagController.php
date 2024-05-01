<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Factories\Flag;
use Illuminate\Http\Request;

class ComponentFlagController extends Controller
{
    /**
     * Display the flag at the top of the page.
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p>Flag is a global component that cannot be enabled by page field.</p>
';

        $components = [
            'accordion' => [
                'data' => [
                    0 => [
                        'promo_item_id' => 'promoGroupDetails',
                        'title' => 'Promo group details',
                        'description' => '',
                        'table' => [
                            'Title' => 'Smaller upercase text',
                            'Excerpt' => 'Larger italicized text',
                            'Link' => 'URL',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                ],
            ],
        ];

        // Assign components globally
        $request->data['base']['components'] = $components;

        $request->data['base']['flag'] = app(Flag::class)->create(1, true);

        return view('childpage', merge($request->data));
    }
}
