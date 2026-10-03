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
                    <h2>Creating a base module</h2>
                    <p><code class="bg-gray-200 py-1 px-2 rounded text-sm">php artisan base:module expanding-grid</code></p>
                    <pre class="code-block">$ php artisan base:module expanding-grid
resources/views/components/expanding-grid.blade.php written successfully.
styleguide/Http/Controllers/ComponentExpandingGridController.php written successfully.
styleguide/menu.json written successfully.
styleguide/Pages/ComponentExpandingGrid.php written successfully.

"modular-expanding-grid" is now ready to use. 🚀</pre>
                    <h2>Creating a site-specific module</h2>
                    <p>To scaffold a module within a site namespace (configured via <code class="bg-gray-200 py-1 px-2 rounded text-sm">SITE_NAMESPACE</code> in <code class="bg-gray-200 py-1 px-2 rounded text-sm">.env</code>, defaulting to <code class="bg-gray-200 py-1 px-2 rounded text-sm">Site</code>), use the <code class="bg-gray-200 py-1 px-2 rounded text-sm">--site</code> flag:</p>
                    <p><code class="bg-gray-200 py-1 px-2 rounded text-sm">php artisan base:module expanding-grid --site</code></p>
                    <p>Or specify a site namespace directly:</p>
                    <p><code class="bg-gray-200 py-1 px-2 rounded text-sm">php artisan base:module expanding-grid --site=Nursing</code></p>
                    <h3>Command result</h3>
                    <pre class="code-block">$ php artisan base:module expanding-grid --site=Nursing
resources/views/nursing/components/expanding-grid.blade.php written successfully.
app/Nursing/Styleguide/Controllers/ComponentExpandingGridController.php written successfully.
app/Nursing/Styleguide/menu.json written successfully.
app/Nursing/Styleguide/Pages/ComponentExpandingGrid.php written successfully.

"modular-expanding-grid" is now ready to use. 🚀</pre>
                    <h3>Customizing the component</h3>
                    <p><ol>
                        <li>Update <code class="bg-gray-200 py-1 px-2 rounded text-sm">app/Nursing/Styleguide/Pages/ComponentExpandingGrid.php</code> to provide a description of the modular component</li>
                        <li>Update <code class="bg-gray-200 py-1 px-2 rounded text-sm">app/Nursing/Styleguide/Controllers/ComponentExpandingGridController.php</code> to include required fields and config options</li>
                        <li>Update <code class="bg-gray-200 py-1 px-2 rounded text-sm">resources/views/nursing/components/expanding-grid.blade.php</code> to create the HTML of the component</li>
                        <li>Add the "modular-expanding-grid" custom page field to the CMS site to start using component on pages</li>
                    </ol></p>
                    <h2>Overriding existing Base modules</h2>
                    <p>To override an existing base modular component (e.g. accordion), create a file with the same relative path in <code class="bg-gray-200 py-1 px-2 rounded text-sm">resources/views/{site_slug}/components/accordion.blade.php</code>. Laravel will automatically check the site view directory first before falling back to the base component view.</p>',
                ],
            ],


        ]);
    }
}
