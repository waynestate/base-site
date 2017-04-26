<?php

namespace App\Repositories;

use Contracts\Repositories\ProfileRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;

class ProfileRepository implements ProfileRepositoryContract
{
    /** @var Connector */
    protected $wsuApi;

    /** @var ParsePromos */
    protected $parsePromos;

    /** @var Repository */
    protected $cache;

    /**
     * Construct the ProfileRepository.
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

        // Make sure the return is an array
        $profiles['profiles'] = ! isset($profile_listing['error']) ? $profile_listing : [];

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

        $groupsArray = collect($profile_groups['results'])->map(function ($item) {
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

            return $this->wsuApi->sendRequest($params['method'], $params)['profiles'];
        });

        $profile['profile'] = isset($profiles[$site_id]) ? $profiles[$site_id] : null;

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

        return collect($profile['profile']['data'])->filter(function ($value, $key) use ($name_fields) {
            return in_array($key, $name_fields) && $value != '';
        })->implode(' ');
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
            return config('app.profile_default_back_url');
        }

        return $referer;
    }
}
