<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Profile View Back Url
    |--------------------------------------------------------------------------
    |
    | Back URL to use when viewing a Individual Profile view in place for the
    | "Return to Listing" link.
    |
    */
    'profile_default_back_url' => '/profiles',

    /*
    |--------------------------------------------------------------------------
    | Profile Parent Group
    |--------------------------------------------------------------------------
    |
    | This will limit the groups displayed to only the children groups under
    | this ID. Typically the group is called "Departments". If all desired
    | groups are added to the root then leave this value as 0.
    |
    */
    'profile_parent_group_id' => 0,

    /*
    |--------------------------------------------------------------------------
    | People Parent Group
    |--------------------------------------------------------------------------
    |
    | This will limit the groups displayed to only the children groups under
    | this ID. Typically the group is called "Departments". If all desired
    | groups are added to the root then leave this value as 0.
    |
    */
    'people_parent_group_id' => 0,

    /*
    |--------------------------------------------------------------------------
    | Profile Group ID
    |--------------------------------------------------------------------------
    |
    | This will limit the groups displayed to only the children groups under
    | this ID. Typically the group is called "Departments". If all desired
    | groups are added to the root then leave this value as null. 
    | This value is a pipe delimited string of group ids.
    |
    */
    'profile_group_id' => null,

    /*
    |--------------------------------------------------------------------------
    | Profile Site ID
    |--------------------------------------------------------------------------
    |
    | This will limit the profiles displayed to only the profiles under
    | this site ID. If all desired profiles are added to the current then leave
    | this value as null.
    |
    */
    'profile_site_id' => null,

    /*
    |--------------------------------------------------------------------------
    | Table of Contents - Contact Table
    |--------------------------------------------------------------------------
    |
    | This will hide the table of contents on the contact table page.
    |
    */
    'table_of_contents' => null,
];
