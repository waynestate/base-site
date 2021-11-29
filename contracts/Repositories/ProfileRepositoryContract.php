<?php

namespace Contracts\Repositories;

interface ProfileRepositoryContract
{
    /**
     * Get the profile listing.
     *
     * @param int $site_id
     * @param int $selected_group
     * @return array
     */
    public function getProfiles($site_id, $selected_group);

    /**
     * Gets the profiles based on promo_group_id custom field and generates anchors for each group
     *
     * @param int $site_id
     * @param string $groups
     * @return array
     */
    public function getProfilesByGroupOrder($site_id, $groups);

    /**
     * Get the dropdown config options.
     *
     * @param int $selected_group
     * @param int $forced_profile_group_id
     * @return array
     */
    public function getDropdownOptions($selected_group, $forced_profile_group_id);

    /**
     * Get the dropdown of groups.
     *
     * @param int $site_id
     * @return array
     */
    public function getDropdownOfGroups($site_id);

    /**
     * Get the persons profile information.
     *
     * @param int $site_id
     * @param string $accessid
     * @return array
     */
    public function getProfile($site_id, $accessid);

    /**
     * Get the fields to show and hide.
     *
     * @return array
     */
    public function getFields();

    /**
     * Get the page title from the profile name.
     *
     * @param array $profile
     * @return string
     */
    public function getPageTitleFromName($profile);

    /**
     * Get the back url based on the http referer.
     *
     * @param string $referer
     * @param string $scheme
     * @param string $host
     * @param string $uri
     * @return string
     */
    public function getBackToProfileListUrl($referer, $scheme, $host, $uri);

    /**
     * Get the Site ID based off the request data
     *
     * @param array $data
     * @return int
     */
    public function getSiteID($data);
}
