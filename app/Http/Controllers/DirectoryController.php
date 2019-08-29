<?php
/*
* Status: Public
* Description: Directory Template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\ProfileRepositoryContract;
use Illuminate\Http\Request;

class DirectoryController extends Controller
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
     * Display directory listing view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $site_id = !empty($request->data['data']['profile_site_id']) ? $request->data['data']['profile_site_id'] : $request->data['site']['id'];

        $profiles = $this->profile->getProfilesByGroup($site_id);

        return view('directory', merge($request->data, $profiles));
    }
}
