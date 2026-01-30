<?php

/*
* Status: Public
* Description: ContactTable Template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\ProfileRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactTableController extends Controller
{
    protected ProfileRepositoryContract $profile;

    /**
     * Construct the controller.
     */
    public function __construct(ProfileRepositoryContract $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Display the view.
     */
    public function index(Request $request): View
    {
        // Parse profile config from custom fields
        $this->profile->parseProfileConfig($request->data['base']);

        // Determine what site to pull profiles from
        $site_id = $this->profile->getSiteID($request->data['base']);

        $profiles = $this->profile->getProfilesByGroupOrder($site_id, config('base.profile.group_id'), $request->data['base']['site']['subsite-folder'] ?? null);

        // show table of contents if custom field 'table_of_contents' is not set to 'hide'
        if (config('base.profile.table_of_contents') === 'hide') {
            $profiles['anchors'] = [];
        }

        return view('contact-tables', merge($request->data, $profiles));
    }
}
