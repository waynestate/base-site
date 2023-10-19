<?php
/*
* Status: Private
* Description: Modular Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Contracts\Repositories\ModularPageRepositoryContract;
use Contracts\Repositories\EventRepositoryContract;
use Contracts\Repositories\ArticleRepositoryContract;

class ModularPageController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param ArticleRepositoryContract $article
     * @param EventRepositoryContract $event
     */
    public function __construct(ModularPageRepositoryContract $promo, ArticleRepositoryContract $article, EventRepositoryContract $event)
    {
        $this->promo = $promo;
        $this->article = $article;
        $this->event = $event;
    }

    /**
     * Display the homepage view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $promos['promos'] = $this->promo->getModularPromos($request->data['base']);

        $articles = $this->article->listing($request->data['base']['data']['news_application_id'] ?? $request->data['base']['site']['news']['application_id']);

        $events = $this->event->getEvents($request->data['base']['data']['event_listing_site_id'] ?? $request->data['base']['site']['id']);

        return view('modular/modularpage', merge($request->data, $articles, $events, $promos));
    }
}
