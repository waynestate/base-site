<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\EventRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MiniEventsController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param EventsRepositoryContract $events
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
    public function index(Request $request)
    {
        $events = $this->events->getEvents($request->data['site']['id']);

        return view('styleguide-minievents', merge($request->data, $events));
    }
}
