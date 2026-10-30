<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ProfilesRow extends Page
{
    /** @var string */
    public $path = '/styleguide/profiles-row';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ProfileController',
                'title' => 'Profiles row',
                'id' => 101115,
                'content' => [
                    'main' => '<p>Profiles are configurable within the CMS page custom field using a custom field named "profile-config". Setting <code>columns</code> to <code>1</code> displays profiles in a single column with the photo on the left and information on the right.</p>

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
"columns": 1,
"listing_fields": ["Title", "Department", "Email"]
}
</pre>
                                </td>
                            </tr>
                        </tbody>
                    </table>',
                ],
            ],
            'data' => [
                'profile-config' => json_encode([
                    'columns' => 1,
                    'listing_fields' => ['Title', 'Department', 'Email'],
                ]),
            ],
        ]);
    }
}
