<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use Contracts\Repositories\EventRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsListingController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(EventRepositoryContract $events)
    {
        $this->events = $events;
    }

    /**
     * Display the mini events view.
     */
    public function index(Request $request): View
    {
        $events = $this->events->getEvents($request->data['base']['site']['id']);

        return view('styleguide-events-listing', merge($request->data, $events));
    }
}
