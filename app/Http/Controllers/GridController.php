<?php
/*
* Status: Public
* Description: Grid Template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\PromoRepositoryContract;
use Illuminate\Http\Request;

class GridController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param PromoRepositoryContract $promo
     * @param NewsRepositoryContract $news
     * @param EventRepositoryContract $event
     */
    public function __construct(PromoRepositoryContract $promo)
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
        $promos = $this->promo->getGridPromos();

        return view('grid', merge($request->data, $promos));
    }
}
