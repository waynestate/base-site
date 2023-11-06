@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

        <div class="grid grid-cols-1 md:grid-cols-2 items-start gap-y-8 sm:gap-x-4 lg:gap-x-8 mt-8 mb-4">
            @include('modular/components/catalog', ['data' => $catalog_1['data'], 'component' => $catalog_1['component']])
        </div>

        <h3>Configuration</h3>
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

<hr />

        <div class="grid grid-cols-1 md:grid-cols-2 items-start gap-y-8 sm:gap-x-4 lg:gap-x-8 mt-8 mb-4">
            @include('modular/components/catalog', ['data' => $catalog_2['data'], 'component' => $catalog_2['component']])
        </div>

        <h3>Configuration</h3>
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

<hr />

@endsection
