@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('partials.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}

        <p>Using components empowers the web team with greater flexibility to achieve diverse web objectives. You can display multiple data sets—like promo groups, events and news—on a single page by adding custom page fields for each component. The available components are listed in this menu.</p>
        <p>For adding multiple components of the same type (e.g., two accordions on a page), simply increase the number in the page field. For instance, use <code>modular-accordion-1</code> and <code>modular-accordion-2</code> to include two accordions.</p>

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

        <h2 id="component-options-explained">Component options explained</h2>
        <h3>All components</h3>
        <table class="mt-2">
            <thead>
                <tr>
                    <th class="w-1/5">Property</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-bold">id</td>
                    <td>
<code class="mt-1 mb-2">"id":12345</code><br />
Promo group ID, News application ID, Events site ID
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">backgroundImageUrl</td>
                    <td>
<code class="mt-1 mb-2">"backgroundImageUrl":"https://wayne.edu/image.jpg"</code><br />
URL for a component background image.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">columnSpan</td>
                    <td>
<code class="mt-1 mb-2">"columnSpan":6</code><br />
Add a width to your column. Column widths can span from 1 to 12 available columns. <a href="/styleguide/templateguide">Read about columnSpan.</a>
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">classes</td>
                    <td>
<code class="mt-1 mb-2">"classes":"bg-green text-white py-gutter-xl"</code><br />
A string of classes to modify your component.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">heading</td>
                    <td>
<code class="mt-1 mb-2">"heading":"My heading"</code><br />
Add a component heading
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">headingClass</td>
                    <td>
<code class="mt-1 mb-2">"headingClass":"text-green"</code><br />
Add any number of classes to a component heading.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">headingLevel</td>
                    <td>
<code class="mt-1 mb-2">"headingLevel":"h3"</code><br />
Change default component heading level from h2 to h3 or h4.
                    </td>
                </tr>
        </table>

        <h3>Page config</h3>
        <p>Customization options for any childpage template. See <a href="/styleguide/component/pageconfig">page config reference</a>.</p>
        <table class="mt-2">
            <thead>
                <tr>
                    <th class="w-1/5">Property</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-bold">showPageMenu</td>
                    <td>
<code class="mt-1 mb-2">"showPageMenu": false</code><br />
Hide the left menu.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">showBreadcrumbs</td>
                    <td>
<code class="mt-1 mb-2">"showBreadcrumbs": false</code><br />
Hide the breadcrumbs.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">showPageTitle</td>
                    <td>
<code class="mt-1 mb-2">"showPageTitle": false</code><br />
Visually hide the page title.
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">pageClass</td>
                    <td>
<code class="mt-1 mb-2">"pageClass": "custom-class"</code><br />
Add a custom class to the page.
                    </td>
                </tr>
            </tbody>
        </table>


        <h3>Promotion components</h3>
        <table class="mt-2">
            <thead>
                <tr>
                    <th class="w-1/5">Property</th>
                    <th>Detail</th>
                    <th class="w-1/5">Component</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-bold">config</td>
                    <td>
<code class="mt-1 mb-2">"config":"page_id|randomize|limit:1|youtube"</code><br />
Configuration options for the specific promo group. <br />
Use "page_id" to enable per-page items.<br />
Use "limit:1" to display one item.<br />
Use "randomize" to shuffle the order of promotion items.<br />
Use "youtube" when you are putting a video url in the promo link field to populate the play button overlay.<br />
<a href="https://github.com/waynestate/parse-promos">Detailed promotion config information</a>
                    </td>
                    <td class="font-bold">All promotion components</td>
                </tr>
                <tr>
                    <td class="font-bold">columns</td>
                    <td>
<code class="mt-1 mb-2">"columns":3</code><br />
Define how many columns the component will display.<br />
1 to 4 columns is recommended.
                    </td>
                    <td class="font-bold">
                        Catalog<br /> 
                        Button row<br /> 
                        Icon row<br /> 
                        Events row<br /> 
                        News row
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">singlePromoView</td>
                    <td>
<code class="mt-1 mb-2">"singlePromoView":false</code><br />
Creates a link to a detailed page of a single promo item, like a Spotlight.<br />
True or false; false is default and will use the promotion's link field if it is set.
                    </td>
                    <td class="font-bold">
                        Catalog<br /> 
                        Spotlight<br /> 
                        Promo row, column<br /> 
                        Icon row, column<br /> 
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">showExcerpt</td>
                    <td>
<code class="mt-1 mb-2">"showExcerpt":true</code><br />
Show or hide the promo's excerpt.<br />
True or false; true is default.
                    </td>
                    <td class="font-bold">
                        Catalog<br /> 
                        Spotlight<br /> 
                        Promo row, column<br /> 
                        Icon row, column<br /> 
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">showDescription</td>
                    <td>
<code class="mt-1 mb-2">"showDescription":true</code><br />
Show or hide the promo's description.<br />
True or false; true is default.<br />
Commonly used in conjunction with "singlePromoView" where the description is hidden from the catalog but displayed on the detailed promo page.
                    </td>
                    <td class="font-bold">
                        Catalog<br /> 
                        Spotlight<br /> 
                        Promo row, column<br /> 
                        Icon row, column<br /> 
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">gradientOverlay</td>
                    <td>
<code class="mt-1 mb-2">"gradientOverlay":false</code><br />
Moves the title, excerpt and/description on top of the image with a gradient for contrast.<br />
True or false; false is default.
                    </td>
                    <td class="font-bold">
                        Catalog<br />
                        Promo row<br />
                        Promo column<br />
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">groupByOptions</td>
                    <td>
<code class="mt-1 mb-2">"groupByOptions":false</code><br />
Group promotion items by the options in the options dropdown.<br />
True or false; false is default.
                    </td>
                    <td class="font-bold">Catalog</td>
                </tr>
                <tr>
                    <td class="font-bold">imagePosition</td>
                    <td>
<code class="mt-1 mb-2">"imagePosition":"left"</code><br />
Moves the image from the left to the right, or alternates their position if the item limit is greater than one.<br />
Left, right, alternate; left is default.
                    </td>
                    <td class="font-bold">Promo row</td>
                </tr>
                <tr>
                    <td class="font-bold">imageSize</td>
                    <td>
<code class="mt-1 mb-2">"imageSize":"large"</code><br />
Uses a small (25%) width or large (40%) width.<br />
Small or large; large is default.
                    </td>
                    <td class="font-bold">Promo row</td>
                </tr>
            </tbody>
        </table>


        <h3>News and events components</h3>
        <table class="mt-2">
            <thead>
                <tr>
                    <th class="w-1/5">Property</th>
                    <th>Detail</th>
                    <th class="w-1/5">Component</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-bold">cal_name</td>
                    <td>
<code class="mt-1 mb-2">"cal_name":"main/"</code><br />
The relative url to your calendar that the "more events" link goes to.<br />
Defaults to the site's selected calendar.<br />
                    </td>
                    <td class="font-bold">Events</td>
                </tr>
                <tr>
                    <td class="font-bold">columns</td>
                    <td>
<code class="mt-1 mb-2">"columns":3</code><br />
Define how many columns the component will display.<br />
1 to 4 columns is recommended.
                    </td>
                    <td class="font-bold">
                        Events row<br /> 
                        News row
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">featured</td>
                    <td>
<code class="mt-1 mb-2">"featured":true</code><br />
Display only the articles that have a specific featured image uploaded in the news manager.<br />
True or false; all articles shown by default.
                    </td>
                    <td class="font-bold">News row</td>
                </tr>
                <tr>
                    <td class="font-bold">limit</td>
                    <td>
<code class="mt-1 mb-2">"limit":4</code><br />
Limit the number of items displayed.<br />
Integer; default is 4.<br />
For promotion based components, see "config."
                    </td>
                    <td class="font-bold">News<br />Events</td>
                </tr>
                <tr>
                    <td class="font-bold">link_text</td>
                    <td>
<code class="mt-1 mb-2">"link_text":"Career events"</code><br />
To change "More news" or "More events" to your specific text.
                    </td>
                    <td class="font-bold">News<br />Events</td>
                </tr>
                <tr>
                    <td class="font-bold">news_route</td>
                    <td>
<code class="mt-1 mb-2">"news_route":"/facultynews"</code><br />
Change the url path for news items.
                    </td>
                    <td class="font-bold">News</td>
                </tr>
                <tr>
                    <td class="font-bold">topics</td>
                    <td>
<code class="mt-1 mb-2">"topics":[76, 4]</code><br />
Pass in an array of topics to display.<br />
All topics shown by default.
                    </td>
                    <td class="font-bold">News</td>
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
    <li>modular-layout-config</li>
    <li>modular-news-column</li>
    <li>modular-news-featured-column</li>
    <li>modular-news-row</li>
    <li>modular-page-config</li>
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
