<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeaturedPromoController extends Controller
{
    /**
     * Display an example featured promo.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $promos['featured_promo'] = app('Factories\FeaturedPromo')->create(1, true);

        return view('styleguide-featured-promo', merge($request->data, $promos));
    }
}
