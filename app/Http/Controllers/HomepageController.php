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

        if(empty($request->data['base']['data'])) {
            $components = [
                'modular-news-column' => [
                    'id' => 6,
                    'heading' => 'News',
                    'columnSpan' => 6,
                ],
                'modular-events-column' => [
                    'id' => 1112,
                    'heading' => 'Events',
                    'columnSpan' => 6,
                ],
            ];


            foreach ($components as $componentName => $componentData) {
                //$componentData['component']['id'] = rand(1, 1000);
                $request->data['base']['data']['data'][$componentName] = json_encode($componentData);
            }

            // Add modular components into global data
            $request->data['base']['components'] = $this->components->getModularComponents($request->data['base']['data']);
        }

        return view('homepage', merge($request->data, $promos));
    }
}
