<?php
/*
* Status: Public
* Description: ContactTable Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\View\View;
use Contracts\Repositories\ProfileRepositoryContract;
use Illuminate\Http\Request;

class ContactTableController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param ProfileRepositoryContract $profile
     */
    public function __construct(ProfileRepositoryContract $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Display the view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        // Determine what site to pull profiles from
        $site_id = $this->profile->getSiteID($request->data['base']);

        $profiles = $this->profile->getProfilesByGroupOrder($site_id, $request->data['base']['data']['profile_group_id']);

        // show table of contents if custom field 'table_of_contents' is not set to 'hide'
        if (isset($request->data['base']['data']['table_of_contents']) && $request->data['base']['data']['table_of_contents'] === 'hide') {
            $profiles['anchors'] = [];
        }

        return view('contact-tables', merge($request->data, $profiles));
    }
}
