<?php

/*
* Status: Public
* Description: Directory Template
* Default: false
*/

namespace App\Http\Controllers;

use Illuminate\View\View;
use Contracts\Repositories\ProfileRepositoryContract;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(ProfileRepositoryContract $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Display directory listing view.
     */
    public function index(Request $request): View
    {
        // Parse profile config from custom fields
        $this->profile->parseProfileConfig($request->data['base']);

        // Determine what site to pull profiles from
        $site_id = $this->profile->getSiteID($request->data['base']);

        if (!empty(config('profile.group_id'))) {
            $profiles = $this->profile->getProfilesByGroupOrder($site_id, config('profile.group_id'), $request->data['base']['site']['subsite-folder']);
        } else {
            $profiles = $this->profile->getProfilesByGroup($site_id, $request->data['base']['site']['subsite-folder']);
        }

        return view('directory', merge($request->data, $profiles));
    }
}
