<?php

namespace Styleguide\Repositories;

use App\Repositories\ProfileRepository as Repository;

class ProfileRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getProfiles($site_id, $selected_group = null)
    {
        $limit = $selected_group != null ? rand(2, 5) : 10;

        $profiles['profiles'] = app('Factories\Profile')->create($limit);

        return $profiles;
    }

    /**
     * {@inheritdoc}
     */
    public function getDropdownOfGroups($site_id)
    {
        $groupsArray = collect(app('Factories\ProfileGroup')->create(10))->map(function ($item) {
            return $item['display_name'];
        })->toArray();

        $groups['dropdown_groups'] = ['' => 'All Profiles'] + $groupsArray;

        return $groups;
    }

    /**
     * {@inheritdoc}
     */
    public function getProfile($site_id, $accessid)
    {
        $profile['profile'] = app('Factories\Profile')->create(1);

        return $profile;
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToProfileListUrl($referer = null, $scheme = null, $host = null, $uri = null)
    {
        return '/styleguide/profiles';
    }
}
