<?php

namespace Contracts\Repositories;

interface ProfileRepositoryContract
{
    /**
     * Get the profile listing.
     */
    public function getProfiles(int $site_id, string|array|null $selected_group = null, $subsite_url = null): array;

    /**
     * @param int $site_id
     * @param array|string|null $groups
     * @param $subsite_url
     * @return array
     */
    public function getProfilesByGroup(int $site_id, array|string|null $groups, $subsite_url = null): array;

    /**
     * Gets the profiles based on promo_group_id custom field and generates anchors for each group
     *
     * @param  null  $subsite_url
     */
    public function getProfilesByGroupOrder(?int $site_id, string $groups, $subsite_url = null): array;

    /**
     * Get the dropdown config options.
     *
     * @param array|string|null $selected_group
     * @param int|null $forced_profile_group_id
     * @return mixed
     */
    public function getDropdownOptions(array|string|null $selected_group = null, ?int $forced_profile_group_id = null): mixed;

    /**
     * @param $selected_group
     * @param $forced_profile_group_id
     * @param $dropdown_groups
     * @return mixed
     */
    public function getGroupIds($selected_group, $forced_profile_group_id, $dropdown_groups): mixed;

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
}
