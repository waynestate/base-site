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
    protected ProfileRepositoryContract $profile;

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

        if (!empty(config('base.profile.group_id'))) {
            $profiles = $this->profile->getProfilesByGroupOrder($site_id, config('base.profile.group_id'), $request->data['base']['site']['subsite-folder']);
        } else {
            $profiles = $this->profile->getProfilesByGroup($site_id, $request->data['base']['site']['subsite-folder']);
        }

        if (!empty(config('base.profile.profiles_by_accessid'))) {
            foreach ($profiles['profiles'] as $department_name => $department) {
                $profiles['profiles'][$department_name] = $this->profile->orderProfilesById($department, config('base.profile.profiles_by_accessid'));
            }
        }

        return view('directory', merge($request->data, $profiles));
    }
}
