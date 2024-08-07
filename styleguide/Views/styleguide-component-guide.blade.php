@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}

        <p>Using components empowers the web team with greater flexibility to achieve diverse web objectives. You can display multiple data sets—like promo groups, events and news—on a single page by adding custom page fields for each component. The available components are listed in this menu.</p>
        <p>For adding multiple components of the same type (e.g., two accordions on a page), simply increase the number in the page field. For instance, use <code>modular-accordion-1</code> and <code>modular-accordion-2</code> to include two accordions.</p>
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
                    <td><pre class="w-full">modular-catalog-1</pre></td>
                    <td>
<pre class="w-full" tabindex="0">
{!! htmlspecialchars('{
"id":000000,
"heading":"Example component appearance",
"columns":3,
"showExcerpt":true,
"showDescription":false,
"singlePromoView":true,
"config":"randomize|page_id|limit:5"
}') !!}
</pre>
                    </td>
                </tr>
            </tbody>
        </table>

        <h3 id="json-data-explained">JSON data explained</h3>
        <p>Legend: <span class="text-[red]">*</span> Designates a required configuration.</p>
        <table class="mt-2">
            <thead>
                <tr>
                    <th>Key</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-bold">id</td>
                    <td>Promo group ID<span class="text-[red]">*</span>, News application ID, Events site ID</td>
                </tr>
                <tr>
                    <td class="font-bold">heading</td>
                    <td>Add a component heading<br />Default is h2</td>
                </tr>
                <tr>
                    <td class="font-bold">headingClass</td>
                    <td>Add any number of classes to a component heading.<br />"text-green divider-gold"</td>
                </tr>
                <tr>
                    <td class="font-bold">headingLevel</td>
                    <td>Change default component heading level from h2 to h3 or h4.<br />"h3"</td>
                </tr>
                <tr>
                    <td class="font-bold">config</td>
                    <td>
Configuration options for the specific promo group. <br />
Use "page_id" to enable per-page items.<br />
Use "limit:1" to display one item.<br />
Use "randomize" to shuffle the order of promotion items.<br />
Use "youtube" when you are putting a video url in the promo link field to populate the play button overlay.<br /> 
<a href="https://github.com/waynestate/parse-promos">Detailed promotion config information</a>
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">columns</td>
                    <td>
Define how many columns the component will display.<br />
1 to 4 columns is recommended.<br />
Use with the catalog, button row, icon row, events row, and news row components.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">singlePromoView</td>
                    <td>
Creates a link to a detailed page of a single promo item, like a Spotlight.<br />
True or false; false is default and will use the promotion's link field if it is set.<br />
Use with the catalog, spoltight, promo row, promo column, and icon components.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">showExcerpt</td>
                    <td>
Show or hide the promo's excerpt.<br />
True or false; true is default.<br />
Use with the catalog, spoltight, promo row, promo column, and icon components.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">showDescription</td>
                    <td>
Show or hide the promo's description.<br />
True or false; true is default.<br />
Commonly used in conjunction with "singlePromoView" where the description is hidden from the catalog but displayed on the detailed promo page.<br />
Use with the catalog, spoltight, promo row, promo column, and icon components.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">gradientOverlay</td>
                    <td>
Moves the title, excerpt and/description on top of the image with a gradient for contrast.<br />
True or false; false is default.<br />
Promo row, promo column, and catalog components only.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">groupByOptions</td>
                    <td>
Group promotion items by the options in the options dropdown.<br />
True or false; false is default.<br />
Catalog component only.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">imagePosition</td>
                    <td>
Moves the image from the left to the right, or alternates their position if the item limit is greater than one.<br />
Left, right, alternate; left is default.<br />
Promo row component only.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">imageSize</td>
                    <td>
Uses a small (25%) width or large (40%) width.<br />
Small or large; large is default.<br />
Promo row component only.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">limit</td>
                    <td>
Limit the number of items displayed.<br />
Integer; default is 4.<br />
News and events only. For promotion based components, see "config."
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">link_text</td>
                    <td>
To change "More news" or "More events" to your specific text, i.e. "Student news", "Career events".<br />
News and Events only.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">news_route</td>
                    <td>
Change the url path for news items. Example: "/facultynews"<br />
Null default; Example: "/facultynews"<br />
News components only.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">featured</td>
                    <td>
Display only the articles that have a specific featured image uploaded in the news manager.<br />
True or false; all articles shown by default.<br />
News row only.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">topics</td>
                    <td>
Pass in an array of topics to display i.e. [76, 4]<br />
All topics shown by default.<br />
News components only.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">cal_name</td>
                    <td>
The relative url to your calendar that the "more events" link goes to, i.e. "main/".<br />
Defaults to the site's selected calendar.<br />
Events components only.
                    </td>
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
    <li>modular-accordion-1</li>
    <li>modular-button-column-1</li>
    <li>modular-button-row-1</li>
    <li>modular-catalog-1</li>
    <li>modular-events-column-1</li>
    <li>modular-events-featured-column-1</li>
    <li>modular-events-featured-row-1</li>
    <li>modular-events-row-1</li>
    <li>modular-heading-1</li>
    <li>modular-hero-1</li>
    <li>modular-icons-column-1</li>
    <li>modular-icons-row-1</li>
    <li>modular-icons-top-row-1</li>
    <li>modular-news-column-1</li>
    <li>modular-news-featured-column-1</li>
    <li>modular-news-row-1</li>
    <li>modular-page-content-row</li>
    <li>modular-page-content-column</li>
    <li>modular-promo-column-1</li>
    <li>modular-promo-row-1</li>
    <li>modular-spotlight-column-1</li>
    <li>modular-spotlight-row-1</li>
</ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
