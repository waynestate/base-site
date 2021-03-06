<?php
/*
* Status: Public
* Description: ContactTable Template
* Default: false
*/

namespace App\Http\Controllers;

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
    public function index(Request $request)
    {
        // Determine what site to pull profiles from
        $site_id = !empty($request->data['data']['profile_site_id']) ? $request->data['data']['profile_site_id'] : $request->data['site']['id'];

        $profiles = $this->profile->getProfilesByGroupOrder($site_id, $request->data['data']['profile_group_id']);

        // show table of contents if custom field 'table_of_contents' is not set to 'hide'
        if (isset($request->data['data']['table_of_contents']) && $request->data['data']['table_of_contents'] === 'hide') {
            $profiles['anchors'] = [];
        }

        return view('contact-tables', merge($request->data, $profiles));
    }
}
