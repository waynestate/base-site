<?php
/*
* Status: Private
* Description: Modular Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Contracts\Repositories\ModularPageRepositoryContract;

class ModularPageController extends Controller
{
    /**
     * Construct the controller.
     *
     */
    public function __construct(ModularPageRepositoryContract $modular)
    {
        $this->modular = $modular;
    }

    /**
     * Display the homepage view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $components['components'] = $this->modular->getModularComponents($request->data['base']);

        // Use one controller for all styleguide component page data
        if (using_styleguide() && !empty($request->data['base']['components'])) {
            $components['components'] = $request->data['base']['components'];
        }

        // Set hero from components
        if (empty($request->data['base']['hero'])) {
            $hero = collect($components['components'])->reject(function ($data, $component_name) {
                return !str_contains($component_name, 'hero');
            })->toArray();

            $hero_key = array_key_first($hero);

            if(!empty($hero)) {
                $request->data['base']['hero'] = $components['components'][$hero_key]['data'];
            }

            unset($components['components'][$hero_key]);
        }

        return view('modularpage', merge($request->data, $components));
    }
}
