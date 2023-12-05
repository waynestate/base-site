<?php
/*
* Status: Public
* Description: Promo Page template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\View\View;
use Contracts\Repositories\PromoPageRepositoryContract;
use Illuminate\Http\Request;

class PromoPageController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(PromoPageRepositoryContract $promo)
    {
        $this->promo = $promo;
    }

    /**
     * Display the view.
     *
     *
     * @return \Illuminate\View\View|void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function index(Request $request): View
    {
        $promos = $this->promo->getPromoPagePromos($request->data['base']);

        return view('promo-page', merge($request->data, $promos));
    }
}
