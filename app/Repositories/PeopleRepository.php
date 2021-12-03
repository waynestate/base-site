<?php

namespace App\Repositories;

use Contracts\Repositories\ProfileRepositoryContract;
use Illuminate\Cache\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Waynestate\Api\People;

class PeopleRepository implements ProfileRepositoryContract
{
    /** @var People */
    protected $peopleApi;

    /** @var Repository */
    protected $cache;

    /**
     * Construct the repository.
     *
     * @param people $peopleApi
     * @param Repository $cache
     */
    public function __construct(People $peopleApi, Repository $cache)
    {
        $this->peopleApi = $peopleApi;
        $this->cache = $cache;
    }

    /**
     * Get the profile listing.
     *
     * @param int $site_id
     * @param int $selected_group
     * @return array
     */
    public function getProfiles($site_id, $selected_group = null)
    {
        $params = [
            'site_id' => $site_id,
            'method' => 'sites/'.$site_id.'/users',
            'groups' => $selected_group,
            'env' => config('app.env'),
        ];

        $profiles = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            try {
                return $this->peopleApi->request($params['method'], $params);
            } catch (\Exception $e) {
                return [];
            }
        });

        $profile_return['profiles'] = [];
        if (!empty($profiles['data'])) {
            $profile_return['profiles'] = collect($profiles['data'])->mapWithKeys(function ($profile) {
                $profile['link'] = '/profile/'.$profile['accessid'];

                foreach ($profile['field_data'] as $data) {
                    $profile['data'][$data['field']['name']] = $data['value'];
                }
                $profile['data']['AccessID'] = $profile['accessid'];

                $profile['groups'] = collect($profile['groups'])->keyBy('id')->toArray();

                return [$profile['data']['AccessID'] => $profile];
            })
            ->sortBy('last_name')
            ->toArray();
        }

        return $profile_return;
    }

    /**
     * Gets the profiles based on promo_group_id custom field and generates anchors for each group
     *
     * @param int $site_id
     * @param string $groups
     * @return array
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
        $grouped = collect($all_profiles['profiles'])->keyBy('data.AccessID')
            ->groupBy(function ($profile) {
                return collect($profile['groups'])->pluck('name')->toArray();
            })
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
    public function getProfilesByGroupOrder($site_id, $groups)
    {
        $profile_listing = $this->getProfiles($site_id);

        $group_order = explode(',', $groups);

        $profiles['profiles'] = [];

        // Retain the order of the groups as they were piped in
        if (!empty($profile_listing)) {
            foreach ($group_order as $group) {
                foreach ($profile_listing['profiles'] as $profile) {
                    if (array_key_exists($group, $profile['groups'])) {
                        $group_name = $profile['groups'][$group]['name'];
                        $profiles['profiles'][$group_name][] = $profile;
                        $profiles['anchors'][$group_name] = Str::slug($group_name);
                    }
                }
            }
        }

        return $profiles;
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
     * Get the dropdown of groups.
     *
     * @param int $site_id
     * @return array
     */
    public function getDropdownOfGroups($site_id)
    {
        $params = [
            'method' => 'sites/'.$site_id.'/groups',
            'env' => config('app.env'),
        ];

        $profile_groups = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            try {
                return $this->peopleApi->request($params['method'], $params);
            } catch (\Exception $e) {
                return [];
            }
        });

        if (!empty($profile_groups['data'])) {
            // Filter down the groups based on the parent group from the config
            $profile_groups['data'] = collect($profile_groups['data'])
                ->filter(function ($item) {
                    return (int)$item['parent_id'] === config('base.profile_parent_group_id');
                })
                ->toArray();

            // Only return the display name ordered by the display order
            $groupsArray = collect($profile_groups['data'])
                ->sortBy('display_order')
                ->mapWithKeys(function ($item) {
                    return [$item['id'] => $item['name']];
                })->toArray();
        } else {
            $groupsArray = [];
        }

        $groups['dropdown_groups'] = ['' => 'All Profiles'] + $groupsArray;

        return $groups;
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
            $group_ids = ltrim(implode(array_keys($dropdown_groups), ','), ',');
        }

        return $group_ids;
    }

    /**
     * Get the persons profile information.
     *
     * @param int $site_id
     * @param string $accessid
     * @return array
     */
    public function getProfile($site_id, $accessid)
    {
        $params = [
            'site_id' => $site_id,
            'method' => 'users/'.$accessid.'/sites/'.$site_id,
            'env' => config('app.env'),
        ];

        $profile = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            try {
                return $this->peopleApi->request($params['method'], $params);
            } catch (\Exception $e) {
                return [];
            }
        });

        $profile_return['profile'] = [];
        if (!empty($profile['data'])) {
            $profile['data']['link'] = '/profile/'.$profile['data']['accessid'];

            foreach ($profile['data']['field_data'] as $data) {
                $profile['data']['data'][$data['field']['name']] = $data['value'];
            }

            $profile_return['profile'] = $profile['data'];
        }

        return $profile_return;
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
            ->sortBy(function ($value, $key) use ($name_fields) {
                return array_search($key, $name_fields);
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

    /**
     * {@inheritdoc}
     */
    public function getSiteID($data)
    {
        return !empty($data['data']['profile_site_id']) ? $data['data']['profile_site_id'] : $data['site']['people']['site_id'];
    }
}
