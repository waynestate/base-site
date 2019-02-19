<?php
/*
* Status: Public
* Description: Grid Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GridController extends Controller
{
    /**
     * Display the grid view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get grid promotions
        $promos = $this->promo->getGridPromos();

        return view('grid', merge($request->data, $promos));
    }
}
