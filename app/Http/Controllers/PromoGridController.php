<?php
/*
* Status: Public
* Description: Grid Promotion Template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\PromoGridRepositoryContract;
use Illuminate\Http\Request;

class PromoGridController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param GridRepositoryContract $promo
     */
    public function __construct(PromoGridRepositoryContract $promo)
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
        $promos = $this->promo->getGridPromos($request->data);

        return view('promo-grid', merge($request->data, $promos));
    }
}
