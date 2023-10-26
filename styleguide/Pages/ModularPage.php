<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ModularPage extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPageController',
                'title' => 'Modular page',
                'id' => 101110600,
                'content' => [
                    'main' => '
                        <p>Use this template to display multiple promo groups on a single page. Row components will be full width, column components will be half. You will want to pair two columns next to each other.</p>
                        <p class="mb-8">To change the order of the components, we currently have to replace or delete and re-add the custom field.</p>
                        <ul class="accordion mt-4">
                            <li>
                                <a href="#definition-page-setup" id="definition-page-setup"><span aria-hidden="true"></span>Page setup</a>
                                <div class="content">
                                    <ul>
                                        <li>Select template "Modular Page."</li>
                                        <li>Select from the following custom page fields:
                                            <ul class="columns-2">
                                                <li><code>modular-accordion-1</code></li>
                                                <li><code>modular-content-row-1</code></li>
                                                <li><code>modular-video-row-1</code></li>
                                                <li><code>modular-button-row-1</code></li>
                                                <li><code>modular-catalog-1</code></li>
                                                <li><code>modular-button-column-1</code></li>
                                                <li><code>modular-steps-column-1</code></li>
                                                <li><code>modular-image-column-1</code></li>
                                                <li><code>modular-video-column-1</code></li>
                                                <li><code>modular-news-column-1</code></li>
                                                <li><code>modular-events-column-1</code></li>
                                            </ul>
                                        </li>
                                        <li>Add a new page field and increase the number if you need to repeat that component, ex. modular-accordion-7.</li>
                                        <li>Paste this JSON array into the page field and edit the values to set options:<br />
<pre>
{
"id":00000,
"heading":"My heading",
"config":"randomize|limit:60|page_id",
"columns":4,
"singlePromoView":"true",
"showExcerpt":"false",
"showDescription":"true",
}
</pre>
                                            <table class="mt-2">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">JSON settings</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="font-bold">id</td>
                                                        <td>Promo group ID. Required.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-bold">heading</td>
                                                        <td>Provide a heading(h2) for this component. Optional.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-bold">config</td>
                                                        <td>Promo group config, pipe delimited. Use \'page_id\' for per-page items. \'First\' is not allowed and will be removed. Optional.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-bold">columns</td>
                                                        <td>Only use with catalog component; 2, 3, or 4. Default/unset is 1. Optional.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-bold">singlePromoView</td>
                                                        <td>True or false. False (default) will use the promotion\'s link field. Optional.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-bold">showExcerpt</td>
                                                        <td>True or false. True is default. Optional.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-bold">showDescription</td>
                                                        <td>True or false. True is default. Optional.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#definition-promo-setup" id="definition-promo-setup"><span aria-hidden="true"></span>Promo group setup</a>
                                <div class="content">
                                    <table class="mt-2">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Available fields</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="font-bold">Title</td>
                                                <td>Promo title. Will turn into a link if link field is used or single promo view is set.</td>
                                            </tr>
                                            <tr>
                                                <td class="font-bold">Link</td>
                                                <td>External link. Do not set if using individual promo view.</td>
                                            </tr>
                                            <tr>
                                                <td class="font-bold">Excerpt</td>
                                                <td>Single line of unformatted text, like a job title.</td>
                                            </tr>
                                            <tr>
                                                <td class="font-bold">Description</td>
                                                <td>Formattable text. Main body content for single promo view.</td>
                                            </tr>
                                            <tr>
                                                <td class="font-bold">Filename</td>
                                                <td>600x450px, or minimum width 600px any height.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                        </ul>
                    ',
                ],
            ],
            'site' => [
                'subsite-folder' => 'styleguide/',
                'news' => [
                    'application_id' => 1,
                ],
            ],
            'data' => [
                'modular-events-column-1' => 1,
                'events_url' => '/main',
                'modular-news-column-1' => 2,
                'buttons' => '{}',
                'image-promos' => '{}',
                'spotlight' => '{}',
                'steps' => '{}',
                'text-promo' => '{}',
                'video' => '{}',
            ],
        ]);
    }
}
