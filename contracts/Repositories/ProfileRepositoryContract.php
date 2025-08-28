<?php

namespace Contracts\Repositories;

interface ProfileRepositoryContract
{
    /**
     * Get the profile listing.
     */
    public function getProfiles(int $site_id, ?string $selected_group = null, $subsite_url = null): array;

    /**
     * Get the profiles based on promo_group_id custom field
     */
    public function getProfilesByGroup($site_id, $subsite_url = null): array;

    /**
     * Gets the profiles based on promo_group_id custom field and generates anchors for each group
     *
     * @param  int  $site_id
     * @param  string  $groups
     */
    public function getProfilesByGroupOrder($site_id, $groups, $subsite_url = null): array;

    /**
     * Get the dropdown config options.
     *
     * @param  int|null  $selected_group
     * @param  int|null  $forced_profile_group_id
     * @param  array  $profiles
     * @return array
     */
    public function getDropdownOptions($selected_group, $forced_profile_group_id, $profiles = []);

    /**
     * Get the dropdown of groups.
     */
    public function getDropdownOfGroups(int $site_id): array;

    /**
     * Get the persons profile information.
     */
    public function getProfile(int $site_id, string $accessid): array;

    /*
     * Get the articles for the profile if available
     *
     * @param string $accessid
     * @param int $limit
     *
     * @return array
     */
    public function getNewsArticles($accessid, $limit = 10);

    /**
     * Get the fields to show and hide.
     *
     * @return array
     */
    public function getFields();

    /**
     * Get the page title from the profile name.
     *
     * @param  array  $profile
     * @return string
     */
    public function getPageTitleFromName($profile);

    /**
     * Get the back url based on the http referer.
     *
     * @param  string|null  $referer
     * @param  string|null  $scheme
     * @param  string|null  $host
     * @param  string|null  $uri
     * @return string
     */
    public function getBackToProfileListUrl($referer, $scheme, $host, $uri);

    /**
     * Get the Site ID based off the request data
     *
     * @param  array  $data
     * @return int
     */
    public function getSiteID($data);

    /**
     * Parse the profile config from the custom fields
     */
    public function parseProfileConfig(array $data): void;

    /**
     * Get the group IDs to filter by.
     *
     * @param  string|null  $selected_group
     * @param  string|null  $forced_profile_group_id
     * @param  array  $dropdown_groups
     * @return string
     */
    public function getGroupIds($selected_group, $forced_profile_group_id, $dropdown_groups);

    /**
     * Orders profiles by a pipe-delimited AccessID sequence from $profiles_by_accessid and appends any remaining profiles afterward.
     *
     * @param $profile_listing
     * @param $profiles_by_accessid
     * @return array
     */
    public function orderProfilesById($profile_listing, $profiles_by_accessid): array;
}
