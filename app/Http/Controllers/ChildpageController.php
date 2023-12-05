<?php
/*
* Status: Public
* Description: Childpage Template
* Default: true
*/

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Contracts\Repositories\PromoRepositoryContract;
use Contracts\Repositories\ModularPageRepositoryContract;

class ChildpageController extends Controller
{
    /**
     * Construct the controller.
     *
     */
    public function __construct(
        PromoRepositoryContract $promo,
        ModularPageRepositoryContract $components
    ) {
        $this->promo = $promo;
        $this->components = $components;
    }

    /**
     * Display the childpage view.
     */
    public function index(Request $request): View
    {
        $components['components'] = [];

        if(!empty($request->data['base']['data'])) {
            $components['components'] = $this->components->getModularComponents($request->data['base']);

            // Set hero from components
            $hero = collect($components['components'])->reject(function ($data, $component_name) {
                return !str_contains($component_name, 'hero');
            })->toArray();
        }

        if(!empty($hero)) {
            $hero_key = array_key_first($hero);

            $request->data['base']['hero'] = $components['components'][$hero_key]['data'];

            unset($components['components'][$hero_key]);

            config(['base.hero_full_controllers' => ['ModularPageController']]);
        }

        return view('childpage', merge($request->data, $components));
    }

    /**
     * Display individual promo item.
     *
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function show(Request $request): View
    {
        $promo = $this->promo->getPromoView($request->id);

        if (empty($promo['promo'])) {
            abort('404');
        }

        if (!empty($promo['promo']['title'])) {
            $request->data['base']['page']['title'] = $promo['promo']['title'];
        }

        // Set the back URL
        $request->data['back_url'] = $this->promo->getBackToPromoPage($request->server->get('HTTP_REFERER'), $request->server->get('REQUEST_SCHEME'), $request->server->get('HTTP_HOST'), $request->server->get('REQUEST_URI'));

        return view('promo-view', merge($request->data, $promo));
    }
}
