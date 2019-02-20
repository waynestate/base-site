<?php
/*
* Status: Public
* Description: Grid Template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\GridRepositoryContract;
use Illuminate\Http\Request;

class GridController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param GridRepositoryContract $promo
     */
    public function __construct(GridRepositoryContract $promo)
    {
        $this->promo = $promo;
    }

    /**
     * Display the grid view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get grid promotions
        $promos = $this->promo->getGridPromos($request->data);

        return view('grid', merge($request->data, $promos));
    }
}
