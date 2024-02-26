<?php
/*
* Status: Public
* Description: Childpage Template
* Default: true
*/

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Contracts\Repositories\ModularPageRepositoryContract;

class ChildpageController extends Controller
{
    /**
     * Construct the controller.
     *
     */
    public function __construct(
        ModularPageRepositoryContract $components
    ) {
        $this->components = $components;
    }

    /**
     * Display the childpage view.
     */
    public function index(Request $request): View
    {
        $components['components'] = [];

        if(!empty($request->data['base']['data'])) {
            $components['components'] = $this->components->getModularComponents($request->data['base']);

            // Set hero from components
            $hero = collect($components['components'])->reject(function ($data, $component_name) {
                return !str_contains($component_name, 'hero');
            })->toArray();
        }

        if(!empty($hero)) {
            $hero_key = array_key_first($hero);

            $request->data['base']['hero'] = $components['components'][$hero_key]['data'];

            config(['base.hero_full_controllers' => ['ChildpageController']]);

            unset($components['components'][$hero_key]);
        }

        return view('childpage', merge($request->data, $components));
    }
}
