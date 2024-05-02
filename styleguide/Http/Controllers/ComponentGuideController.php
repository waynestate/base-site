<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Factories\GenericPromo;

class ComponentGuideController extends Controller
{
    /**
     * Display the banner at the top of the page.
     */
    public function index(Request $request): View
    {
        $components = [
            'accordion_configuration' => [
                'data' => [
                    0 => [
                        'title' => 'Page setup',
                        'description' => '',
                        'promo_item_id' => 0,
                    ],
                    1 => [
                        'title' => 'Configuration',
                        'description' => '',
                        'promo_item_id' => 0,
                    ],
                ],
                'component' => [
                    'filename' => 'accordion',
                ],
            ],
            'catalog_1' => [
                'data' => app(GenericPromo::class)->create(5, false, [
                    'description' => '',
                    'link' => '/styleguide/view/title-12345',
                ]),
                'component' => [
                    'heading' => 'Example component appearance',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                    'singlePromoView' => true,
                ],
            ],
        ];

        return view('styleguide-component-guide', merge($request->data, $components));
    }
}
