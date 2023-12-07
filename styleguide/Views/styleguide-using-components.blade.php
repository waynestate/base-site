@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}

        <p>You can display multiple data sets, like promo groups, events, and news, on a single page by adding custom page fields for each component. The available components are listed in this menu.</p>
        <p>To add multiple components of the same type, like two accordions on a page, you will need to increment the number in the page field; i.e. <code>modular-accordion-1</code>, <code>modular-accordion-2</code></p>
        <p class="mb-8">To change the order of the components, you will need to copy and paste your data in the correct order until we develop a better way to rearrange page fields.</p>

        <h2>Full width component page fields</h2>
        <ul class="columns-2">
            <li><code>modular-hero-1</code></li>
            <li><code>modular-accordion-1</code></li>
            <li><code>modular-content-row-1</code></li>
            <li><code>modular-video-row-1</code></li>
            <li><code>modular-button-row-1</code></li>
            <li><code>modular-catalog-1</code></li>
        </ul>

        <h2>Column components</h2>
        <ul class="columns-2">
            <li><code>modular-button-column-1</code></li>
            <li><code>modular-icons-column-1</code></li>
            <li><code>modular-image-column-1</code></li>
            <li><code>modular-video-column-1</code></li>
            <li><code>modular-news-column-1</code></li>
            <li><code>modular-events-column-1</code></li>
        </ul>

        <h2>Configuring components</h2>
        <p>You will use a JSON array paired with your page field to configure each component. The specifics of each component can be found on the individual component page from the menu.</p>
        <h3>Example component configuration</h3>
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
"config":"randomize|limit:5|page_id"
}') !!}
</pre>
                    </td>
                </tr>
            </tbody>
        </table>

        <h3>JSON data explained</h3>
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
                    <td>Add a component heading (h2)</td>
                </tr>
                <tr>
                    <td class="font-bold">config</td>
                    <td>Configuration options for the specific promo group. <br />Use "page_id" to enable per-page items. Use "limit:1" instead of "first" to display one item.<br /><a href="https://github.com/waynestate/parse-promos">Detailed promotion config information</a></td>
                </tr>
                <tr>
                    <td class="font-bold">columns</td>
                    <td>1 to 4 columns is recommended. Use with the catalog, button row, and news components.</td>
                </tr>
                <tr>
                    <td class="font-bold">singlePromoView</td>
                    <td>True or false, false is default and will use the promotion's link field if it is set.<br />Creates a link to a detailed page of a single promo item, like a Spotlight.</td>
                </tr>
                <tr>
                    <td class="font-bold">showExcerpt</td>
                    <td>True or false, true is default.<br />Show or hide the promo's excerpt.</td>
                </tr>
                <tr>
                    <td class="font-bold">showDescription</td>
                    <td>True or false, true is default.<br />Show or hide the promo's description. Commonly used in conjunction with "singlePromoView" where the description is hidden from the catalog but displayed on the detailed promo page.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 items-start gap-y-8 sm:gap-x-4 lg:gap-x-8 mt-8 mb-4">
        <div class="col-span-full">
            <h2 class="mt-0">{{ $catalog_1['component']['heading'] }}</h2>
            @include('components/catalog', ['data' => $catalog_1['data'], 'component' => $catalog_1['component']])
        </div>
    </div>

@endsection
