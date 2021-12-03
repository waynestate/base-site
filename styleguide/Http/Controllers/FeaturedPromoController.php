<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Factories\FeaturedPromo;
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
        $promos['featured_promo'] = app(FeaturedPromo::class)->create(1, true);

        return view('styleguide-featured-promo', merge($request->data, $promos));
    }
}
