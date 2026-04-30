<?php

/*
* Status: Public
* Description: Promotion View Template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\PromoRepositoryContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
     * Placeholder for WildcardController calling PromoController::index to redirect back to the configured
     * app.url
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return response()->redirectTo(config('app.url'));
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

        // Update to append the slug and promo id to match the current URL structure
        if (!empty($request->data['base']['page']['canonical'])) {
            $request->data['base']['page']['canonical'] .= '/' . Str::slug($promo['promo']['title']) . '-' .
                $promo['promo']['promo_item_id'];
        }

        // Set the back URL
        $request->data['back_url'] = $this->promo->getBackToPromoPage($request->server->get('HTTP_REFERER'), $request->server->get('REQUEST_SCHEME'), $request->server->get('HTTP_HOST'), $request->server->get('REQUEST_URI'));

        return view('promo-view', merge($request->data, $promo));
    }
}
