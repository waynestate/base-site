<?php
/*
* Status: Public
* Description: Promo Listing template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\PromoListingRepositoryContract;
use Illuminate\Http\Request;

class PromoListingController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param PromoListingRepositoryContract $promo
     */
    public function __construct(PromoListingRepositoryContract $promo)
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
        $promos = $this->promo->getPromoListingPromos($request->data);

        return view('promo-listing', merge($request->data, $promos));
    }
}
