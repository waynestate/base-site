<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use Contracts\Repositories\EventRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MiniEventsController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param EventRepositoryContract $events
     */
    public function __construct(EventRepositoryContract $events)
    {
        $this->events = $events;
    }

    /**
     * Display the mini events view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $events = $this->events->getEvents($request->data['base']['site']['id']);

        return view('styleguide-minievents', merge($request->data, $events));
    }
}
