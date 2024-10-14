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

        if (!empty($request->data['base']['data'])) {
            $modularComponents['modularComponents'] = $this->modularComponent->getModularComponents($request->data['base']);
            $promos['components'] = $modularComponents['modularComponents'];
        }

        $articles = $this->article->listing($request->data['base']['site']['news']['application_id']);

        $events = $this->event->getEvents($request->data['base']['site']['id']);

        return view('homepage', merge($request->data, $promos, $articles, $events));
    }
}
