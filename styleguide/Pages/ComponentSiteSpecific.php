<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentSiteSpecific extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Creating site specific modules',
                'id' => 999900,
                'content' => [
                    'main' => '<p>Module names should be singular and kebab-case.</p>
                    <h2>Example new features</h2>
                    <ul><li>"Spotlight" <code class="bg-gray-200 py-1 px-2 rounded text-sm">php artisan base:module spotlight</code></li>
                    <li>"Expanding Grid" <code class="bg-gray-200 py-1 px-2 rounded text-sm">php artisan base:module expanding-grid</code></li></ul>
                    <h3>"Expanding Grid" command result</h3>
                    <pre class="code-block">$ php artisan base:module expanding-grid
resources/views/site-specific/components/expanding-grid.blade.php written successfully.
styleguide/Http/Controllers/Custom/ComponentExpandingGridController.php written successfully.
styleguide/menu.json written successfully.
styleguide/Pages/Custom/ComponentExpandingGrid.php written successfully.

"modular-expanding-grid" is now ready to use. 🚀</pre>
                    <h3>Customizing the component</h3>
                    <p><ol>
                        <li>Update `styleguide/Pages/Custom/ComponentExpandingGrid.php` to provide a description of the modular component</li>
                        <li>Update `styleguide/Http/Controllers/Custom/ComponentExpandingGridController.php` to include required fields and config options</li>
                        <li>Update `resources/views/site-specific/components/expanding-grid.blade.php` to create the HTML of the component</li>
                        <li>Add the "modular-expanding-grid" custom page field to the CMS site to start using component on pages</li>
                    </ol></p>',
                ],
            ],


        ]);
    }
}
