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

        foreach($components['components'] as $key => $component) {
            if (str_contains($key, 'hero')) {
                $request->data['base']['hero'] = $components['components'][$key]['data'];
                unset($components['components'][$key]);
            }
        }

        // Make it a full width view
        $request->data['base']['show_site_menu'] = false;

        return view('modularpage', merge($request->data, $components));
    }
}
