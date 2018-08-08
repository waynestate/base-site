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
        $spotlights = $this->getSpotlights();

        return view('spotlight', merge($request->data, $spotlights));
    }
}
