<?php
/*
* Status: Private
* Description: Homepage Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Contracts\Repositories\PromoRepositoryContract;
use Contracts\Repositories\EventRepositoryContract;
use Contracts\Repositories\ArticleRepositoryContract;

class HomepageController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param PromoRepositoryContract $promo
     * @param ArticleRepositoryContract $article
     * @param EventRepositoryContract $event
     */
    public function __construct(PromoRepositoryContract $promo, ArticleRepositoryContract $article, EventRepositoryContract $event)
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
        // $promos = $this->promo->getHomepagePromos();

        $articles = $this->article->listing($request->data['base']['site']['news']['application_id']);

        $events = $this->event->getEvents($request->data['base']['site']['id']);

        return view('homepage', merge($request->data, $articles, $events));
    }
}
