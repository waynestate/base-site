<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Directory extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'DirectoryController',
                'title' => 'Directory',
                'id' => 101107,
                'content' => ['main' => '<p>Configurable with in the CMS page custom field. Using a custom field named "profile_config".</p>
                    <table class="mt-2">
                        <thead>
                            <tr>
                                <th>Page field</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><pre class="w-full">profile_config</pre></td>
                                <td>
<pre class="w-full" tabindex="0">
{
"site_id":000000,
"group_id":"1234|5678",
"parent_group_id":"1234",
"table_of_contents":"hide",
"default_back_url":"/profiles/",
}
</pre>
                                </td>
                            </tr>
                        </tbody>
                    </table>'],
            ],
        ]);
    }
}
