@extends('layouts.' . (!empty($layout) ? $layout : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="w-full md:w-1/2">
        @if(!empty($articles['data']))
            <h2>News column</h2>
            @include('components/news-column', ['data' => $articles])
        @endif
    </div>
    
    <div class="w-full mt-8">
        @if(!empty($articles['data']))
            <h2>News row</h2>
            @include('components/news-row', ['data' => $articles])
        @endif
    </div>
    
    <h3 class="mt-8">Configuration</h3>
    <div class="grid grid-cols-1 lg:grid-cols-3 border-x border-b mb-16">
        <div class="lg:col-span-1 p-2 bg-gray-100 font-bold lg:border-r border-y order-1 lg:order-none">Page field</div>
        <div class="lg:col-span-2 p-2 bg-gray-100 font-bold border-y order-3 lg:order-none">Data</div>
        <div class="lg:col-span-1 p-2 lg:border-r order-2 lg:order-none">
            <pre class="w-full">modular-news-column-1</pre>
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
@endsection
