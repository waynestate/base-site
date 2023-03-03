<?php

namespace Contracts\Repositories;

interface ProfileRepositoryContract
{
    /**
     * Get the profile listing.
     *
     * @param int $site_id
     * @param int|null $selected_group
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
     * @param int|null $selected_group
     * @param int|null $forced_profile_group_id
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
     * @param array $profile
     * @return string
     */
    public function getPageTitleFromName($profile);

    /**
     * Get the back url based on the http referer.
     *
     * @param string|null $referer
     * @param string|null $scheme
     * @param string|null $host
     * @param string|null $uri
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
