<?php
/*
* Status: Public
* Description: Spotlight Template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\SpotlightRepositoryContract;
use Illuminate\Http\Request;

class SpotlightController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param SpotlightRepositoryContract $spotlight
     */
    public function __construct(SpotlightRepositoryContract $spotlight)
    {
        $this->spotlight = $spotlight;
    }

    /**
     * Display the view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $spotlights = $this->spotlight->getSpotlights($request->data);

        return view('spotlight-listing', merge($request->data, $spotlights));
    }

    /**
     * Display the individual featured person.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $spotlight = $this->spotlight->getSpotlight($request->id);

        if (empty($spotlight['spotlight'])) {
            return abort('404');
        }

        if (!empty($spotlight['spotlight']['title'])) {
            $request->data['page']['title'] = $spotlight['spotlight']['title'];
        }

        // Set the back URL
        $request->data['back_url'] = $this->spotlight->getBackToSpotlightsListing($request->server->get('HTTP_REFERER'), $request->server->get('REQUEST_SCHEME'), $request->server->get('HTTP_HOST'), $request->server->get('REQUEST_URI'));

        return view('spotlight-view', merge($request->data, $spotlight));
    }
}
