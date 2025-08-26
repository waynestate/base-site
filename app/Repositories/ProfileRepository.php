<?php

namespace App\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Waynestate\Api\Connector;
use Illuminate\Cache\Repository;
use Waynestate\Youtube\ParseId;
use Waynestate\Api\News;
use Waynestate\Promotions\ParsePromos;
use Contracts\Repositories\ProfileRepositoryContract;
use Illuminate\Support\Facades\Config;

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
     */
    public function __construct(Connector $wsuApi, ParsePromos $parsePromos, Repository $cache, News $newsApi)
    {
        $this->wsuApi = $wsuApi;
        $this->parsePromos = $parsePromos;
        $this->cache = $cache;
        $this->newsApi = $newsApi;
    }

    /**
     * {@inheritdoc}
     */
    public function getProfiles(int $site_id, ?string $selected_group = null, $subsite_url = null): array
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
            $profile_listing = collect($profile_listing)->map(function ($item) use ($subsite_url) {
                $item['link'] = '/'.$subsite_url.'profile/'.$item['data']['AccessID'];

                $item['full_name'] = $this->getPageTitleFromName(['profile' => $item]);

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
    public function getProfilesByGroup($site_id, $subsite_url = null): array
    {
        // Get the groups for the dropdown
        $dropdown_groups = $this->getDropdownOfGroups($site_id);

        // Determine which group(s) to filter by
        $group_ids = $this->getGroupIds(null, null, $dropdown_groups['dropdown_groups']);

        // Get all the profiles
        $all_profiles = $this->getProfiles($site_id, $group_ids, $subsite_url);

        // Organize profiles by the group they are in keyed by accessid
        $grouped = collect($all_profiles['profiles'])->keyBy('data.AccessID')
        ->groupBy([
            function ($profile) {
                return $profile['groups'];
            },
        ], $preserveKeys = true)
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
    public function getProfilesByGroupOrder($site_id, $groups, $subsite_url = null): array
    {
        $profile_listing = $this->getProfiles($site_id, null, $subsite_url);

        $group_order = preg_split('/[\s,|]+/', $groups);

        $profiles = [];

        // Retain the order of the groups as they were piped in
        if (!empty($profile_listing)) {
            foreach ($group_order as $group) {
                foreach ($profile_listing['profiles'] as $profile) {
                    if (array_key_exists($group, $profile['groups'])) {
                        $profiles['profiles'][$profile['groups'][$group]][] = $profile;
                        $profiles['anchors'][$profile['groups'][$group]] = Str::slug($profile['groups'][$group]);
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
     * {@inheritdoc}
     */
    public function getGroupIds($selected_group, $forced_profile_group_id, $dropdown_groups)
    {
        // Use the selected group or the forced one from custom page fields
        $group_ids = $forced_profile_group_id === null ? $selected_group : $forced_profile_group_id;

        // Use all the IDs from the dropdown since the initial selection is "All Profiles"
        if ($group_ids === null) {
            $group_ids = ltrim(implode('|', array_keys($dropdown_groups)), '|');
        }

        return $group_ids;
    }

    /**
     * {@inheritdoc}
     */
    public function getDropdownOfGroups(int $site_id): array
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
        $parent_group_id = (config('base.profile_parent_group_id')) ?? config('base.profile.parent_group_id');
        $profile_groups['results'] = collect($profile_groups['results'])
            ->filter(function ($item) use ($parent_group_id) {
                return (int) $item['parent_id'] === $parent_group_id;
            })
            ->toArray();

        // Only return the display name ordered by the display order
        $groupsArray = collect($profile_groups['results'])
            ->sortBy('display_order')
            ->map(function ($item) {
                return $item['display_name'];
            })->toArray();

        if (count($groupsArray) == 1) {
            $groups['single_group'] = key($groupsArray);
        }

        $groups['dropdown_groups'] = ['' => 'All Profiles'] + $groupsArray;

        return $groups;
    }

    /**
     * {@inheritdoc}
     */
    public function getProfile(int $site_id, string $accessid): array
    {
        $params = [
            'method' => 'profile.users.view',
            'site_id' => $site_id,
            'accessid' => $accessid,
            'include_courses' => 'true',
        ];

        $profiles = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            $this->wsuApi->nextRequestProduction();

            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        if (!empty($profiles['error'])) {
            return ['profile' => []];
        }

        if (!empty($profiles['profiles'][$site_id]['data']['Youtube Videos'])) {
            $profiles['profiles'][$site_id]['data']['Youtube Videos'] = collect($profiles['profiles'][$site_id]['data']['Youtube Videos'])->map(function ($video) use ($profiles, $site_id) {
                return [
                    'youtube_id' => ParseId::fromUrl($video['link']),
                    'link' => $video['link'],
                    'filename_alt_text' => $profiles['profiles'][$site_id]['data']['First Name'] . ' ' .
                        $profiles['profiles'][$site_id]['data']['Last Name'] . ' video',
                ];
            })->toArray();
        }

        if (!empty($profiles['profiles'])) {
            $profiles['profiles']['articles'] = $this->getNewsArticles($accessid, 10);
        }

        return [
            'profile' =>  Arr::get($profiles['profiles'], $site_id, []),
            'courses' => Arr::get($profiles, 'courses', []),
            'articles' => Arr::get($profiles['profiles'], 'articles', []),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getNewsArticles($accessid, $limit = 10)
    {
        $params = [
            'perPage' =>  $limit,
            'method' => 'articles/faculty/'.$accessid,
            'env' => config('app.env'),
        ];

        $articles = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            try {
                $articles = $this->newsApi->request($params['method'], $params);

                return $articles['data'] ?? [];
            } catch (\Exception $e) {
                return [];
            }
        });

        return $articles;
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
                'Youtube Videos',
            ],
            // Hide these in the main tube of content
            'hidden_fields' => [
                'Title',
                'AccessID',
                'Suffix',
                'Honorific',
                'First Name',
                'Middle name',
                'Last Name',
                'Picture',
                'Photo Download',
                'Youtube Videos',
            ],
            // Build the users name based on these fields
            'name_fields' => [
                'Honorific',
                'First Name',
                'Middle name',
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
        if (empty($profile)) {
            return '';
        }

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
            return (config('base.profile_default_back_url')) ?? config('base.profile.default_back_url');
        }

        return $referer;
    }

    /**
     * {@inheritdoc}
     */
    public function getSiteID($data)
    {
        return !empty(config('base.profile.site_id')) ? config('base.profile.site_id') : $data['site']['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function parseProfileConfig(array $data): void
    {
        $profile_config = [];

        if (!empty($data['data']['profile-config'])) {
            // Remove all spaces and line breaks
            $value = preg_replace('/\s*\R\s*/', '', $data['data']['profile-config']);

            // Last item cannot have comma at the end of it
            $value = preg_replace('(,})', '}', $value);

            // Parse the JSON
            if (Str::startsWith($value, '{')) {
                $profile_config = json_decode($value, true);

                foreach ($profile_config as $key => $value) {
                    Config::set('base.profile.'.$key, $value);
                }
            }
        }

        // Legacy support for profile_group_id
        if (!empty($data['data']['profile_group_id']) && empty($profile_config['group_id'])) {
            Config::set('base.profile.group_id', $data['data']['profile_group_id']);
        }

        // Legacy support for profile_site_id
        if (!empty($data['data']['profile_site_id']) && empty($profile_config['site_id'])) {
            Config::set('base.profile.site_id', $data['data']['profile_site_id']);
        }

        // Legacy support for table_of_contents
        if (!empty($data['data']['table_of_contents']) && empty($profile_config['table_of_contents'])) {
            Config::set('base.profile.table_of_contents', $data['data']['table_of_contents']);
        }

        // Legacy support for profiles_by_accessid
        if (!empty($data['data']['profiles_by_accessid'])) {
            Config::set('base.profile.profiles_by_accessid', $data['data']['profiles_by_accessid']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function orderProfilesById($profile_listing, $profiles_by_accessid)
    {
        $accessids = collect(explode('|', $profiles_by_accessid))->map(function ($item) {
            return trim($item);
        })->all();

        // Find the profiles by a specific order
        $profiles_ordered = collect($accessids)->map(function ($accessid) use ($profile_listing) {
            return collect($profile_listing)->firstWhere('data.AccessID', $accessid);
        })->filter(null);

        // Remove the profiles that we found so there aren't duplicates
        $profiles_all = collect($profile_listing)->reject(function ($profile) use ($accessids) {
            return in_array($profile['data']['AccessID'], $accessids);
        });

        return $profiles_ordered->merge($profiles_all)->toArray();
    }

    /**
     * Get unique groups from a collection of profiles.
     *
     * @param array $profiles
     * @return array
     */
    protected function getUniqueGroupsFromProfiles(array $profiles): array
    {
        return collect($profiles)
            ->filter(function ($profile) {
                return !empty($profile['groups']) && is_array($profile['groups']);
            })
            ->flatMap(function ($profile) {
                return array_values($profile['groups']);
            })
            ->unique()
            ->values()
            ->toArray();
    }
}
