<?php

/*
* Status: Public
* Description: Promotion View Template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\PromoRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PromoController extends Controller
{
    protected PromoRepositoryContract $promo;

    /**
     * Construct the controller.
     */
    public function __construct(PromoRepositoryContract $promo)
    {
        $this->promo = $promo;
    }

    /**
     * Display individual promo item.
     *
     *
     * @throws HttpException
     * @throws NotFoundHttpException|\Exception
     */
    public function show(Request $request): View
    {
        $promo = $this->promo->getPromoView($request->id);

        if (empty($promo['promo'])) {
            abort(404);
        }

        if (! empty($promo['promo']['title'])) {
            $request->data['base']['page']['title'] = $promo['promo']['title'];
        }

        // Set the back URL
        $request->data['back_url'] = $this->promo->getBackToPromoPage($request->server->get('HTTP_REFERER'), $request->server->get('REQUEST_SCHEME'), $request->server->get('HTTP_HOST'), $request->server->get('REQUEST_URI'));

        return view('promo-view', merge($request->data, $promo));
    }
}
