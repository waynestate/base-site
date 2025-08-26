<?php

/*
* Status: Private
* Description: Homepage Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Contracts\Repositories\HomepageRepositoryContract;

class HomepageController extends Controller
{
    protected HomepageRepositoryContract $promo;

    /**
     * Construct the controller.
     */
    public function __construct(
        HomepageRepositoryContract $promo,
    ) {
        $this->promo = $promo;
    }

    /**
     * Display the homepage view.
     */
    public function index(Request $request): View
    {
        // $request->data['base']['show_site_menu'] = false;

        // Add news and events component
        $request->data['base'] = $this->promo->getHomepageComponents($request->data['base']);

        return view('childpage', merge($request->data));
    }
}
