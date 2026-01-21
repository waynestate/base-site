<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Profiles extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ProfileController',
                'title' => 'Profile listing',
                'id' => 101105,
                'content' => [
                    'main' => '<p>Profiles are configurable with in the CMS page custom field. Using a custom field named "profile-config". Additionally, the "profile-config" is need on the profile view page. </p>

                    <table class="mt-2">
                        <thead>
                            <tr>
                                <th>Page field</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><pre class="w-full">profile-config</pre></td>
                                <td>
<pre class="w-full" tabindex="0">
{
"site_id":000000,
"group_id":"1234,5678",
"parent_group_id":"1234",
"table_of_contents":"hide",
"default_back_url":"/profiles",
"profiles_by_accessid":"aa0000,aa0001"
}
</pre>
                                </td>
                            </tr>
                        </tbody>
                    </table>',
                ],
            ],
        ]);
    }
}
