<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Factories\FeaturedPromo;
use Illuminate\Http\Request;

class FeaturedPromoController extends Controller
{
    /**
     * Display an example featured promo.
     */
    public function index(Request $request): View
    {
        $promos['featured_promo'] = app(FeaturedPromo::class)->create(1, true);

        return view('styleguide-featured-promo', merge($request->data, $promos));
    }
}
