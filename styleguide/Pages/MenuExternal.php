<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class MenuExternal extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'MenuTopController',
                'title' => 'External menu icon',
                'id' => 103100102,
                'content' => [
                    'main' => '
<p>Links within the <code>content</code>, <code>main-menu</code> and <code>under-menu</code> classes that contain https://, http://, and // will automatically have an external link icon applied. For an example, this is what it looks like to link to <a href="//wayne.edu">Wayne.edu</a>. This applies to text links as well as buttons. Buttons and links outside of the conditions above will not be modified.</p>
<p>
<a href="#//" class="button mr-4">Button within content class</a>
<a href="#//" class="green-button">Button within content class</a><br />
</p>
                    ',
                ],
            ],
        ]);
    }
}
