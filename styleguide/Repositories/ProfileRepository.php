<?php

namespace Styleguide\Repositories;

use App\Repositories\ProfileRepository as Repository;
use Factories\Profile;
use Factories\ProfileGroup;

class ProfileRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getProfiles($site_id, $selected_group = null)
    {
        $limit = is_int($selected_group) ? rand(2, 5) : 20;

        return [
            'profiles' => app(Profile::class)->create($limit),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getDropdownOfGroups($site_id)
    {
        $groups = collect(app(ProfileGroup::class)->create(10))->map(function ($item) {
            return $item['display_name'];
        })
        ->prepend('All Profiles', '')
        ->toArray();

        return [
            'dropdown_groups' => $groups,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getProfile($site_id, $accessid)
    {
        return [
            'profile' => app(Profile::class)->create(1, true),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToProfileListUrl($referer = null, $scheme = null, $host = null, $uri = null)
    {
        return '/styleguide/profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function sortGroupsByDisplayOrder($grouped, $groups)
    {
        // There is no need to sort the groups in the styleguide since the order is random
        return $grouped;
    }
}
