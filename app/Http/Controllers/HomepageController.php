<?php

/*
* Status: Private
* Description: Homepage Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Contracts\Repositories\HomepageRepositoryContract;
use Contracts\Repositories\ModularPageRepositoryContract;

class HomepageController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(
        HomepageRepositoryContract $promo,
        ModularPageRepositoryContract $components,
    ) {
        $this->promo = $promo;
        $this->components = $components;
    }

    /**
     * Display the homepage view.
     */
    public function index(Request $request): View
    {
        // $request->data['base']['show_site_menu'] = false;

        $promos = $this->promo->getHomepagePromos($request->data);

        if (empty($request->data['base']['data'])) {
            $components = [
                'modular-news-column' => [
                    'heading' => 'News',
                    'columnSpan' => 6,
                ],
                'modular-events-column' => [
                    'heading' => 'Events',
                    'columnSpan' => 6,
                    'classes' => 'mb-gutter',
                ],
            ];

            foreach ($components as $component_name => $component_data) {
                $request->data['base']['data'][$component_name] = json_encode($component_data);
            }

            // Add default homepage components into global data
            $request->data['base']['components'] = $this->components->getModularComponents($request->data['base']);
        }

        return view('childpage', merge($request->data, $promos));
    }
}
