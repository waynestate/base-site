<?php
/*
* Status: Private
* Description: Homepage Template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\PromoRepositoryContract;
use Contracts\Repositories\NewsRepositoryContract;
use Contracts\Repositories\EventRepositoryContract;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param PromoRepositoryContract $promo
     * @param NewsRepositoryContract $news
     * @param EventRepositoryContract $event
     */
    public function __construct(PromoRepositoryContract $promo, NewsRepositoryContract $news, EventRepositoryContract $event)
    {
        $this->promo = $promo;
        $this->news = $news;
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
        //$promos = $this->promo->getHomepagePromos();

        $news = $this->news->getNewsByDisplayOrder($request->data['site']['id']);

        $events = $this->event->getEvents($request->data['site']['id']);

        return view('homepage', merge($request->data, $news, $events));
    }
}
