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
    public function __construct(ModularPageRepositoryContract $promo)
    {
        $this->promo = $promo;
    }

    /**
     * Display the homepage view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $promos['promos'] = $this->promo->getModularPromos($request->data['base']);

        return view('modular/modularpage', merge($request->data, $promos));
    }
}
