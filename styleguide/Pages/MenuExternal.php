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
<p>Links and buttons given the <code>external-link</code> class within the <code>content</code>, <code>main-menu</code> and <code>under-menu</code> sections will display an external link icon.</p>
<p>The icon color will match the text color of the link or button. A screen reader will read (external link) after the link.</p>
<p>This is what it looks like to link to <a href="//wayne.edu" class="external-link">Wayne.edu</a> within a sentence.</p>
<p>Below is an example of two common buttons with the class applied:</p>
<p>
<a href="#" class="inline-block button mr-4 external-link">External link button</a>
<a href="#" class="green-button external-link">Green external link button</a><br />
</p>
                    ',
                ],
            ],
        ]);
    }
}
