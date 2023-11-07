@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 items-start gap-y-8 sm:gap-x-4 lg:gap-x-8 mt-8 mb-4">
        @include('modular/components/catalog', ['data' => $catalog_1['data'], 'component' => $catalog_1['component']])

        <div class="col-span-2">
            <h3 class="mt-0">Configuration</h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 border-x border-b mb-16">
                <div class="lg:col-span-1 p-2 bg-gray-100 font-bold lg:border-r border-y order-1 lg:order-none">Page field</div>
                <div class="lg:col-span-2 p-2 bg-gray-100 font-bold border-y order-3 lg:order-none">Data</div>
                <div class="lg:col-span-1 p-2 lg:border-r order-2 lg:order-none">
                    <pre class="w-full">modular-catalog-1</pre>
                </div>
                <div class="lg:col-span-2 p-2 order-4 lg:order-none">
<pre class="w-full" tabindex="0">
{!! htmlspecialchars('{
"id":1234,
"heading":"Four-column catalog",
"columns":4,
"showExcerpt":true,
"showDescription":false,
"singlePromoView":true,
"config":"limit:8"
}') !!}
</pre>
                </div>
            </div>
        </div>

        @include('modular/components/catalog', ['data' => $catalog_2['data'], 'component' => $catalog_2['component']])

        <div class="col-span-2">
            <h3 class="mt-0">Configuration</h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 border-x border-b mb-16">
                <div class="lg:col-span-1 p-2 bg-gray-100 font-bold lg:border-r border-y order-1 lg:order-none">Page field</div>
                <div class="lg:col-span-2 p-2 bg-gray-100 font-bold border-y order-3 lg:order-none">Data</div>
                <div class="lg:col-span-1 p-2 lg:border-r order-2 lg:order-none">
                    <pre class="w-full">modular-catalog-2</pre>
                </div>
                <div class="lg:col-span-2 p-2 order-4 lg:order-none">
<pre class="w-full" tabindex="0">
{!! htmlspecialchars('{
"id":1234,
"heading":"One-column catalog",
"columns":1,
"showExcerpt":true,
"showDescription":true,
"singlePromoView":true,
"config":"limit:3"
}') !!}
</pre>
                </div>
            </div>
        </div>

        @include('modular/components/accordion', ['data' => $accordion_1['data'], 'component' => $accordion_1['component']])

        <div class="col-span-2">
            <h3 class="mt-0">Configuration</h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 border-x border-b mb-16">
                <div class="lg:col-span-1 p-2 bg-gray-100 font-bold lg:border-r border-y order-1 lg:order-none">Page field</div>
                <div class="lg:col-span-2 p-2 bg-gray-100 font-bold border-y order-3 lg:order-none">Data</div>
                <div class="lg:col-span-1 p-2 lg:border-r order-2 lg:order-none">
                    <pre class="w-full">modular-accordion-1</pre>
                </div>
                <div class="lg:col-span-2 p-2 order-4 lg:order-none">
<pre class="w-full" tabindex="0">
{!! htmlspecialchars('{
"id":1234,
"heading":"My accordion"
}') !!}
</pre>
                </div>
            </div>
        </div>

        @include('modular/components/news-row', ['data' => $news_row_1['data'], 'component' => $news_row_1['component']])

        <div class="col-span-2">
            <h3 class="mt-0">Configuration</h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 border-x border-b mb-16">
                <div class="lg:col-span-1 p-2 bg-gray-100 font-bold lg:border-r border-y order-1 lg:order-none">Page field</div>
                <div class="lg:col-span-2 p-2 bg-gray-100 font-bold border-y order-3 lg:order-none">Data</div>
                <div class="lg:col-span-1 p-2 lg:border-r order-2 lg:order-none">
                    <pre class="w-full">modular-news-row-1</pre>
                </div>
                <div class="lg:col-span-2 p-2 order-4 lg:order-none">
                    For default settings use a blank array
<pre class="w-full" tabindex="0">
{}
</pre>
specify only a heading
<pre class="w-full" tabindex="0">
{!! htmlspecialchars('{
"heading":"News"
}') !!}
</pre>
or configure with these options
<pre class="w-full" tabindex="0">
{!! htmlspecialchars('{
"id":null,
"heading":"News",
"link_text":"More news",
"featured":null,
"limit":4,
"news_route":null,
"topics":[]
}') !!}
</pre>
                </div>
            </div>
        </div>

        @include('modular/components/events-column', ['data' => $events_column_1['data'], 'component' => $events_column_1['component']])

        <div class="col-span-2">
            <h3 class="mt-0">Configuration</h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 border-x border-b mb-16">
                <div class="lg:col-span-1 p-2 bg-gray-100 font-bold lg:border-r border-y order-1 lg:order-none">Page field</div>
                <div class="lg:col-span-2 p-2 bg-gray-100 font-bold border-y order-3 lg:order-none">Data</div>
                <div class="lg:col-span-1 p-2 lg:border-r order-2 lg:order-none">
                    <pre class="w-full">modular-events-column-1</pre>
                </div>
                <div class="lg:col-span-2 p-2 order-4 lg:order-none">
                    For default settings use a blank array
<pre class="w-full" tabindex="0">
{!! htmlspecialchars('{}') !!}
</pre>
specify only a heading
<pre class="w-full" tabindex="0">
{!! htmlspecialchars('{
"heading":"Events"
}') !!}
</pre>
or configure with these options, ID optional
<pre class="w-full" tabindex="0">
{!! htmlspecialchars('{
"id":null,
"heading":"Events",
"config":"limit:4",
"cal_name": "myurl/",
"link_text":"More events"
}') !!}
</pre>
                </div>
            </div>
        </div>
    </div>

@endsection
