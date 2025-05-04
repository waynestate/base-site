@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}

        <p>Using components empowers the web team with greater flexibility to achieve diverse web objectives. You can display multiple data sets—like promo groups, events and news—on a single page by adding custom page fields for each component. The available components are listed in this menu.</p>
        <p>For adding multiple components of the same type (e.g., two accordions on a page), simply increase the number in the page field. For instance, use <code>modular-accordion</code> and <code>modular-accordion-2</code> to include two accordions.</p>
        <p>As for changing the order of components, the current method involves manually copying and pasting data in the desired sequence. We're actively working on a more efficient way to rearrange page fields, streamlining the process for easier reordering.</p>

        <h2>Configuring components</h2>
        <p>You will use a JSON array paired with your page field to configure each component. The specifics of each component can be found on the individual component page from the menu.</p>
        <h3 id="example-component-configurations">Example component configuration</h3>
        <p>Adding this data set into your CMS page fields area will display your promo data as a catalog component.</p>  
        <table class="mt-2">
            <thead>
                <tr>
                    <th>Page field</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><pre class="w-full">modular-catalog</pre></td>
                    <td>
<pre class="w-full" tabindex="0">
{!! htmlspecialchars('{
"id":000000,
"heading":"My heading",
}') !!}
</pre>
                    </td>
                </tr>
            </tbody>
        </table>

        <h3 id="json-data-explained">Component configuration options</h3>
        <table class="mt-2">
            <thead>
                <tr>
                    <th>Option</th>
                    <th class="w-2/5">Description</th>
                    <th>Example data</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-bold">cal_name</td>
                    <td>
The events.wayne.edu relative path to your calendar that "more events" links to.<br />
Defaults to the site's selected calendar.<br />
Events components only.
                    </td>
                    <td><code class="border border-gray-300 mt-2">"cal_name":"main/"</code></td>
                </tr>
                <tr>
                    <td class="font-bold">columnSpan</td>
                    <td>Width of the component; 1-12. All adjacent columns should equal 12; 6+6, 5+7, 4+8, 4+4+4.<br />3=25%, 4=33%, 6=50%<br /></td>
                    <td><code class="border border-gray-300 mt-2">"columnSpan":6</code></td>
                </tr>
                <tr>
                    <td class="font-bold">columns</td>
                    <td>Number of columns to display.<br /> Used with catalog, button row, icons row, events row, news row.</td>
                    <td><code class="border border-gray-300 mt-2">"columns":3</code></td>
                </tr>
                <tr>
                    <td class="font-bold">config</td>
                    <td>Promo item configuration: "page_id" will show items per-page, "limit:1" will display one item, "randomize" will shuffle the order. <a href="https://github.com/waynestate/parse-promos"><br />Promotion config info on github.</a></td>
                    <td><code class="border border-gray-300 mt-2">"config":"page_id"</code>
                    <code class="border border-gray-300 mt-2">"config":"page_id|randomize|limit:1"</code></td>
                </tr>
                <tr>
                    <td class="font-bold">featured</td>
                    <td>
Display only the articles that have a specific featured image uploaded in the news manager.<br />
True or false; all articles shown by default.<br />
News row and events only.
                    </td>
                    <td><code class="border border-gray-300 mt-2">"featured":true</code></td>
                </tr>
                <tr>
                    <td class="font-bold">gradientOverlay</td>
                    <td>
Moves the title, excerpt and/description on top of the image with a gradient for contrast.<br />
True or false; false is default.<br />
Promo row, promo column, and catalog components only.
                    </td>
                    <td><code class="border border-gray-300 mt-2">"gradientOverlay":true</code></td>
                </tr>
                <tr>
                    <td class="font-bold">heading</td>
                    <td>Add a component heading</td>
                    <td><code class="border border-gray-300 mt-2">"heading":"My heading"</code></td>
                </tr>
                <tr>
                    <td class="font-bold">headingClass</td>
                    <td>Add any number of classes to a component heading.</td>
                    <td><code class="border border-gray-300 mt-2">"headingClass":"text-green divider-gold"</code></td>
                </tr>
                <tr>
                    <td class="font-bold">headingLevel</td>
                    <td>Set the component heading level; h2, h3, h4.<br />H2 is default.</td>
                    <td><code class="border border-gray-300 mt-2">"headingLevel":"h3"</code></td>
                </tr>
                <tr>
                    <td class="font-bold">id</td>
                    <td>Promo group ID, News application ID, or Events site ID</td>
                    <td><code class="border border-gray-300 mt-2">"id":00000</code></td>
                </tr>
                <tr>
                    <td class="font-bold">imagePosition</td>
                    <td>
Moves the image from the left to the right, or alternates their position if the item limit is greater than one.<br />
Left, right, alternate; left is default.<br />
Promo row component only.
                    </td>
                    <td><code class="border border-gray-300 mt-2">"imagePosition":right</code></td>
                </tr>
                <tr>
                    <td class="font-bold">imageSize</td>
                    <td>
Uses a small (25%) width or large (40%) width.<br />
Small or large; large is default.<br />
Promo row component only.
                    </td>
                    <td><code class="border border-gray-300 mt-2">"imageSize":small</code></td>
                </tr>
                <tr>
                    <td class="font-bold">limit</td>
                    <td>
Limit the number of items displayed.<br />
Four is default. News and events only. 
                    </td>
                    <td><code class="border border-gray-300 mt-2">"limit":4</code></td>
                </tr>
                <tr>
                    <td class="font-bold">link_text</td>
                    <td>
To change "More news" or "More events" to your specific text, i.e. "Student news", "Career events".<br />
News and Events only.
                    </td>
                    <td><code class="border border-gray-300 mt-2">"link_text":"Career events"</code></td>
                </tr>
                <tr>
                    <td class="font-bold">news_route</td>
                    <td>
Change the url path for news items. Example: "/facultynews"<br />
Null default; Example: "/facultynews"<br />
News components only.
                    </td>
                    <td><code class="border border-gray-300 mt-2">"news_route":"/facultynews"</code></td>
                </tr>
                <tr>
                    <td class="font-bold">showDescription</td>
                    <td>
Show or hide the promo's description.<br />
True or false; true is default.<br />
Commonly used in conjunction with "singlePromoView" where the description is hidden from the catalog but displayed on the detailed promo page.<br />
Use with the catalog, spoltight, promo row, promo column, and icon components.
                    </td>
                    <td><code class="border border-gray-300 mt-2">"showDescription":false</code></td>
                </tr>
                <tr>
                    <td class="font-bold">showExcerpt</td>
                    <td>
Show or hide the promo's excerpt.<br />
True or false; true is default.<br />
Use with the catalog, spoltight, promo row, promo column, and icon components.
                    </td>
                    <td><code class="border border-gray-300 mt-2">"showExcerpt":false</code></td>
                </tr>
                <tr>
                    <td class="font-bold">singlePromoView</td>
                    <td>
Creates a link to page of the promo item.<br />
True or false; true will override the promotion's link field if it is set.<br />
Use with the catalog, spoltight, promo row, promo column, and icon components.
                    </td>
                    <td><code class="border border-gray-300 mt-2">"singlePromoView":true</code></td>
                </tr>
                <tr>
                    <td class="font-bold">topics</td>
                    <td>
Pass in an array of topics to display i.e. [76, 4]<br />
All topics shown by default.<br />
News components only.
                    </td>
                    <td><code class="border border-gray-300 mt-2">"topics":[76, 4]</code></td>
                </tr>
            </tbody>
        </table>

        <h3 id="all-available-components">All available components</h3>
        <table class="mt-2">
            <thead>
                <tr>
                    <th>Page field name</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
<ul class="columns-2">
    <li>modular-accordion</li>
    <li>modular-button-column</li>
    <li>modular-button-row</li>
    <li>modular-catalog</li>
    <li>modular-events-column</li>
    <li>modular-events-featured-column</li>
    <li>modular-events-featured-row</li>
    <li>modular-events-row</li>
    <li>modular-heading</li>
    <li>modular-hero</li>
    <li>modular-icons-column</li>
    <li>modular-icons-row</li>
    <li>modular-icons-top-row</li>
    <li>modular-news-column</li>
    <li>modular-news-featured-column</li>
    <li>modular-news-row</li>
    <li>modular-page-content-row</li>
    <li>modular-page-content-column</li>
    <li>modular-promo-column</li>
    <li>modular-promo-row</li>
    <li>modular-spotlight-column</li>
    <li>modular-spotlight-row</li>
</ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
