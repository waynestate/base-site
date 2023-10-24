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

        return view('modular/modularpage', merge($request->data, $components));
    }
}
