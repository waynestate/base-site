<?php

namespace App\Repositories;

use Illuminate\Support\Arr;
use Waynestate\Api\Connector;
use Illuminate\Cache\Repository;
use Waynestate\Promotions\ParsePromos;
use Contracts\Repositories\ProfileRepositoryContract;

class ProfileRepository implements ProfileRepositoryContract
{
    /** @var Connector */
    protected $wsuApi;

    /** @var ParsePromos */
    protected $parsePromos;

    /** @var Repository */
    protected $cache;

    /**
     * Construct the repository.
     *
     * @param Connector $wsuApi
     * @param ParsePromos $parsePromos
     * @param Repository $cache
     */
    public function __construct(Connector $wsuApi, ParsePromos $parsePromos, Repository $cache)
    {
        $this->wsuApi = $wsuApi;
        $this->parsePromos = $parsePromos;
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function getProfiles($site_id, $selected_group = null)
    {
        $params = [
            'method' => 'profile.users.listing',
            'site_id' => $site_id,
            'groups' => $selected_group,
        ];

        $profile_listing = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            $this->wsuApi->nextRequestProduction();

            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        // Build the link
        if (empty($profile_listing['error'])) {
            $profile_listing = collect($profile_listing)->map(function ($item) {
                $item['link'] = '/profile/'.$item['data']['AccessID'];

                return $item;
            })->toArray();
        }

        // Make sure the return is an array
        $profiles['profiles'] = empty($profile_listing['error']) ? $profile_listing : [];

        return $profiles;
    }

    /**
     * {@inheritdoc}
     */
    public function getProfilesByGroup($site_id)
    {
        // Get the groups for the dropdown
        $dropdown_groups = $this->getDropdownOfGroups($site_id);

        // Determine which group(s) to filter by
        $group_ids = $this->getGroupIds(null, null, $dropdown_groups['dropdown_groups']);

        // Get all the profiles
        $all_profiles = $this->getProfiles($site_id, $group_ids);

        // Organize profiles by the group they are in keyed by accessid
        $grouped = collect($all_profiles['profiles'])->map(function ($profile) {
            return collect($profile['groups'])->flatMap(function ($group) use ($profile) {
                return [
                   'data' => $profile['data'],
                   'groups' => $profile['groups'],
                   'group' => $group,
                   'AccessID' => $profile['data']['AccessID'],
                   'link' => $profile['link'],
               ];
            });
        })
        ->keyBy('AccessID')
        ->groupBy('group', true)
        ->toArray();

        // Follow the ordering of groups from the CMS
        $profiles['profiles'] = $this->sortGroupsByDisplayOrder($grouped, $dropdown_groups['dropdown_groups']);

        return $profiles;
    }

    /**
     * {@inheritdoc}
     */
    public function sortGroupsByDisplayOrder($grouped, $groups)
    {
        return collect($groups)
            ->reject(function ($item, $key) {
                return $key === '';
            })
            ->reject(function ($item, $key) use ($grouped) {
                // Remove groups that no one is in
                return empty($grouped[$item]);
            })
            ->flatMap(function ($item, $key) use ($grouped) {
                return [
                    $item => $grouped[$item],
                ];
            })
            ->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function getDropdownOptions($selected_group = null, $forced_profile_group_id = null)
    {
        // Default Options
        $options['selected_group'] = $selected_group;
        $options['hide_filtering'] = false;

        // If a data page field was set force that filtering and don't show the dropdown
        if ($forced_profile_group_id !== null) {
            $options['selected_group'] = $forced_profile_group_id;
            $options['hide_filtering'] = true;
        }

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroupIds($selected_group, $forced_profile_group_id, $dropdown_groups)
    {
        // Use the selected group or the forced one from custom page fields
        $group_ids = $forced_profile_group_id === null ? $selected_group : $forced_profile_group_id;

        // Use all the IDs from the dropdown since the initial selection is "All Profiles"
        if ($group_ids === null) {
            $group_ids = ltrim(implode(array_keys($dropdown_groups), '|'), '|');
        }

        return $group_ids;
    }

    /**
     * {@inheritdoc}
     */
    public function getDropdownOfGroups($site_id)
    {
        $params = [
            'method' => 'profile.groups.listing',
            'site_id' => $site_id,
        ];

        $profile_groups = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            $this->wsuApi->nextRequestProduction();

            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        // Filter down the groups based on the parent group from the config
        $profile_groups['results'] = collect($profile_groups['results'])
            ->filter(function ($item) {
                return (int) $item['parent_id'] === config('base.profile_parent_group_id');
            })
            ->toArray();

        // Only return the display name ordered by the display order
        $groupsArray = collect($profile_groups['results'])
            ->sortBy('display_order')
            ->map(function ($item) {
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
        $params = [
            'method' => 'profile.users.view',
            'site_id' => $site_id,
            'accessid' => $accessid,
        ];

        $profiles = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            $this->wsuApi->nextRequestProduction();

            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        $profile['profile'] = empty($profiles['error']) ? Arr::get($profiles['profiles'], $site_id, []) : [];

        return $profile;
    }

    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        return [
            // Show under the profile image
            'contact_fields' => [
                'Curriculum Vitae',
                'Syllabi',
                'Phone',
                'Fax',
                'Email',
                'Office',
                'Website',
            ],
            // Fields that should be displayed as a URL
            'url_fields' => [
                'Website',
            ],
            // Show under the profile images contact fields
            'file_fields' => [
                'Curriculum Vitae',
                'Syllabi',
            ],
            // Hide these in the main tube of content
            'hidden_fields' => [
                'Title',
                'AccessID',
                'Suffix',
                'Honorific',
                'First Name',
                'Last Name',
                'Picture',
                'Photo Download',
            ],
            // Build the users name based on these fields
            'name_fields' => [
                'Honorific',
                'First Name',
                'Last Name',
                'Suffix',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTitleFromName($profile)
    {
        $name_fields = $this->getFields()['name_fields'];

        $name = collect($profile['profile']['data'])->filter(function ($value, $key) use ($name_fields) {
            return in_array($key, $name_fields) && $value != '';
        })
            ->map(function ($value, $key) {
                return $key == 'Suffix' ? ', '.$value : $value;
            })
            ->implode(' ');

        return str_replace(' ,', ',', $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToProfileListUrl($referer = null, $scheme = null, $host = null, $uri = null)
    {
        // Make sure the referer is coming from the site we are currently on and not the current page
        if ($referer === null
            || $referer == $scheme.'://'.$host.$uri
            || strpos($referer, $host) === false
        ) {
            return config('base.profile_default_back_url');
        }

        return $referer;
    }
}
