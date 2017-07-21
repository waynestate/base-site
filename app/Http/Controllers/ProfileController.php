<?php
/*
* Status: Public
* Description: Profile Template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\ProfileRepositoryContract;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Construct the ProfileController.
     *
     * @param ProfileRepositoryContract $profile
     */
    public function __construct(ProfileRepositoryContract $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Display profile listing view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Determine what site to pull profiles from
        $site_id = isset($request->data['data']['profile_site_id']) ? $request->data['data']['profile_site_id'] : $request->data['site']['id'];

        // Determine if we are forcing the profiles from custom page data
        $forced_profile_group_id = isset($request->data['data']['profile_group_id']) ? $request->data['data']['profile_group_id'] : null;

        // Get the groups for the dropdown
        $dropdown_groups = $this->profile->getDropdownOfGroups($site_id);

        // Get the options for the dropdown
        $dropdown_group_options = $this->profile->getDropdownOptions($request->query('group'), $forced_profile_group_id);

        // Determine which group to filter by
        $group_id = $forced_profile_group_id === null ? $request->query('group') : $forced_profile_group_id;

        // Get the profiles
        $profiles = $this->profile->getProfiles($site_id, $group_id);

        // Disable hero images
        $request->data['hero'] = false;

        return view('profile-listing', merge($request->data, $profiles, $dropdown_groups, $dropdown_group_options));
    }

    /**
     * Display the individual profile view.
     *
     * @param Request $request
     * @param int $accessid
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $accessid = null)
    {
        // Determine what site to pull profiles from
        $site_id = isset($request->data['data']['profile_site_id']) ? $request->data['data']['profile_site_id'] : $request->data['site']['id'];

        // Get the profile information
        $profile = $this->profile->getProfile($site_id, $accessid);

        // Get the fields to display
        $fields = $this->profile->getFields();

        // Make sure the profile exists
        if ($profile['profile'] === null) {
            return abort('404');
        }

        // Change page title to profile name
        $request->data['page']['title'] = $this->profile->getPageTitleFromName($profile);

        // Set the back URL
        $request->data['back_url'] = $this->profile->getBackToProfileListUrl($request->server->get('HTTP_REFERER'));

        // Make it a full width view
        $request->data['show_site_menu'] = false;

        // Disable hero images
        $request->data['hero'] = false;

        return view('profile-view', merge($request->data, $profile, $fields));
    }
}
