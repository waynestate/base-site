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
use Contracts\Repositories\ModularPageRepositoryContract;
use Contracts\Repositories\EventRepositoryContract;
use Contracts\Repositories\ArticleRepositoryContract;

class HomepageController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(
        HomepageRepositoryContract $promo,
        ModularPageRepositoryContract $components,
        ArticleRepositoryContract $article,
        EventRepositoryContract $event
    ) {
        $this->promo = $promo;
        $this->components = $components;
        $this->article = $article;
        $this->event = $event;
    }

    /**
     * Display the homepage view.
     */
    public function index(Request $request): View
    {
        // $request->data['base']['show_site_menu'] = false;

        // Add news and events component
        $request->data['base'] = $this->promo->getHomepageComponents($request->data['base']);

        return view('homepage', merge($request->data));
    }
}
