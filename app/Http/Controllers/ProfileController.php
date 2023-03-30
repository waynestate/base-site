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
     * Construct the controller.
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
        $site_id = $this->profile->getSiteID($request->data['base']);

        // Determine if we are forcing the profiles from custom page data
        $forced_profile_group_id = !empty($request->data['base']['data']['profile_group_id']) ? $request->data['base']['data']['profile_group_id'] : null;

        // Get the groups for the dropdown
        $dropdown_groups = $this->profile->getDropdownOfGroups($site_id);

        // Set the selected group
        $selected_group = $request->query('group') !== '' ? $request->query('group') : null;

        // Get the options for the dropdown
        $dropdown_group_options = $this->profile->getDropdownOptions($selected_group, $forced_profile_group_id);

        // Determine which group(s) to filter by
        $group_ids = $this->profile->getGroupIds($selected_group, $forced_profile_group_id, $dropdown_groups['dropdown_groups']);

        // Get the profiles
        $profiles = $this->profile->getProfiles($site_id, $group_ids);

        // Disable hero images
        $request->data['base']['hero'] = false;

        return view('profile-listing', merge($request->data, $profiles, $dropdown_groups, $dropdown_group_options));
    }

    /**
     * Display the individual profile view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function show(Request $request)
    {
        if (empty($request->accessid)) {
            abort('404');
        }

        // Determine what site to pull profiles from
        $site_id = $this->profile->getSiteID($request->data['base']);

        // Get the profile information
        $profile = $this->profile->getProfile($site_id, $request->accessid);

        // Make sure the profile exists
        if (empty($profile['profile'])) {
            abort('404');
        }

        // Re-label future and current semesters
        if (!empty($profile['courses'])) {
            foreach ($profile['courses'] as $semester => $courses) {
                // Dedupe courses per-semester
                $courses = collect($courses)->unique(function ($item) {
                    return $item['short_code'].$item['course_number'];
                })->toArray();

                $semester_start = reset($courses)['start_date'];
                $semester_end = reset($courses)['end_date'];

                if ($semester_start > date('Y-m-d')) {
                    $profile['courses'][$semester . ' (future)'] = $courses;
                    unset($profile['courses'][$semester]);
                } elseif ($semester_start <= date('Y-m-d') && $semester_end >= date('Y-m-d')) {
                    $profile['courses'][$semester . ' (current)'] = $courses;
                    unset($profile['courses'][$semester]);
                } else {
                    // To keep the original descending order
                    unset($profile['courses'][$semester]);
                    $profile['courses'][$semester] = $courses;
                }
            }
        }

        // Get the fields to display
        $fields = $this->profile->getFields();

        // Change page title to profile name
        $request->data['base']['page']['title'] = $this->profile->getPageTitleFromName($profile);
        $request->data['base']['page']['canonical'] = $request->data['base']['server']['url'] ?? '';

        // Set the back URL
        $request->data['back_url'] = $this->profile->getBackToProfileListUrl($request->server->get('HTTP_REFERER'), $request->server->get('REQUEST_SCHEME'), $request->server->get('HTTP_HOST'), $request->server->get('REQUEST_URI'));

        // Make it a full width view
        $request->data['base']['show_site_menu'] = false;

        // Disable hero images
        $request->data['base']['hero'] = false;

        return view('profile-view', merge($request->data, $profile, $fields));
    }
}
