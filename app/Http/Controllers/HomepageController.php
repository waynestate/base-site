<?php

/*
* Status: Private
* Description: Homepage Template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\ArticleRepositoryContract;
use Contracts\Repositories\EventRepositoryContract;
use Contracts\Repositories\HomepageRepositoryContract;
use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomepageController extends Controller
{
    protected HomepageRepositoryContract $promo;

    protected ModularPageRepositoryContract $modularComponent;

    protected ArticleRepositoryContract $article;

    protected EventRepositoryContract $event;

    /**
     * Construct the controller.
     */
    public function __construct(
        HomepageRepositoryContract $promo,
        ModularPageRepositoryContract $modularComponent,
        ArticleRepositoryContract $article,
        EventRepositoryContract $event
    ) {
        $this->promo = $promo;
        $this->modularComponent = $modularComponent;
        $this->article = $article;
        $this->event = $event;
    }

    /**
     * Display the homepage view.
     */
    public function index(Request $request): View
    {
        // $request->data['base']['show_site_menu'] = false;

        $promos = $this->promo->getHomepagePromos($request->data);

        $modularComponents['modularComponents'] = [];

        if (! empty($request->data['base']['data'])) {
            $modularComponents['modularComponents'] = $this->modularComponent->getModularComponents($request->data['base']);
            $promos['components'] = $modularComponents['modularComponents'];
        }

        $articles['data'] = $this->article->listing($request->data['base']['site']['news']['application_id']);

        $events = $this->event->getEvents($request->data['base']['site']['id']);

        return view('homepage', merge($request->data, $promos, $articles, $events));
    }
}
