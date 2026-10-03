<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Sitespecific extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Creating site specific templates',
                'id' => 99901,
                'content' => [
                    'main' => '<p>Feature names should be singular and CamelCased.</p>
                    <h2>Creating a base feature</h2>
                    <p><code class="bg-gray-200 py-1 px-2 rounded text-sm">php artisan base:feature Spotlight</code></p>
                    <pre class="code-block">$ php artisan base:feature Spotlight
resources/views/spotlight.blade.php written successfully.
app/Http/Controllers/SpotlightController.php written successfully.
styleguide/menu.json written successfully.
styleguide/Pages/Spotlight.php written successfully.

"Spotlight" is now ready to use. 🚀</pre>
                    <h2>Creating a site-specific feature</h2>
                    <p>To scaffold a feature within a site namespace (configured via <code class="bg-gray-200 py-1 px-2 rounded text-sm">SITE_NAMESPACE</code> in <code class="bg-gray-200 py-1 px-2 rounded text-sm">.env</code>, defaulting to <code class="bg-gray-200 py-1 px-2 rounded text-sm">Site</code>), use the <code class="bg-gray-200 py-1 px-2 rounded text-sm">--site</code> flag:</p>
                    <p><code class="bg-gray-200 py-1 px-2 rounded text-sm">php artisan base:feature Spotlight --site</code></p>
                    <p>Or specify a site namespace directly:</p>
                    <p><code class="bg-gray-200 py-1 px-2 rounded text-sm">php artisan base:feature Spotlight --site=Nursing</code></p>
                    <h3>Command result</h3>
                    <pre class="code-block">$ php artisan base:feature Spotlight --site=Nursing
resources/views/nursing/spotlight.blade.php written successfully.
app/Nursing/Controllers/SpotlightController.php written successfully.
app/Nursing/Styleguide/menu.json written successfully.
app/Nursing/Styleguide/Pages/Spotlight.php written successfully.

"Spotlight" is now ready to use. 🚀</pre>
                    <h3>Customizing the template</h3>
                    <p><ol>
                        <li>Update <code class="bg-gray-200 py-1 px-2 rounded text-sm">app/Nursing/Styleguide/Pages/Spotlight.php</code> to define mock data for the styleguide preview</li>
                        <li>Update <code class="bg-gray-200 py-1 px-2 rounded text-sm">app/Nursing/Controllers/SpotlightController.php</code> to inject repositories and prepare data for the view</li>
                        <li>Update <code class="bg-gray-200 py-1 px-2 rounded text-sm">resources/views/nursing/spotlight.blade.php</code> to create the HTML of the template</li>
                        <li>In the CMS, select <code class="bg-gray-200 py-1 px-2 rounded text-sm">SpotlightController</code> as the template on the page</li>
                    </ol></p>
                    <h2>Overriding existing Base templates</h2>
                    <p>To override a base controller for a site, create a class with the same name in <code class="bg-gray-200 py-1 px-2 rounded text-sm">app/{SiteNamespace}/Controllers/</code> that extends the base controller.</p>
                    <p>To override a base view, place a template with the same relative path in <code class="bg-gray-200 py-1 px-2 rounded text-sm">resources/views/{site_slug}/</code> (e.g. <code class="bg-gray-200 py-1 px-2 rounded text-sm">resources/views/nursing/homepage.blade.php</code>).</p>',
                ],
            ],


        ]);
    }
}
