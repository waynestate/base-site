<?php
/*
* Status: Public
* Description: Topic Listing Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Contracts\Repositories\TopicRepositoryContract;

class TopicController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param TopicRepositoryContract $topic
     */
    public function __construct(TopicRepositoryContract $topic)
    {
        $this->topic = $topic;
    }

    /**
     * Display the topic listing view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $topics = $this->topic->listing($request->data['site']['news']['application_id']);

        if (!empty($topics['topics']['data'])) {
            $topics['topics']['data'] = $this->topic->sortByLetter($topics['topics']['data']);
        }

        return view('topics', merge($request->data, $topics));
    }
}
