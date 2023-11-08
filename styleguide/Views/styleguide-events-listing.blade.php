@extends('layouts.' . (!empty($layout) ? $layout : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="mt-8 md:w-1/2">
        <h2>Events column</h2>
        @if(!empty($events))
            @include('components.events-column', ['data' => $events, 'component' => $component = ['cal_name' => 'main/']])
        @endif
    </div>

    <div class="w-full mt-8">
        <h2>Events row</h2>
        @if(!empty($events))
            @include('components.events-row', ['data' => $events, 'component' => $component = ['cal_name' => 'main/']])
        @endif
    </div>

    <h3 class="mt-8">Configuration</h3>
    <div class="grid grid-cols-1 lg:grid-cols-3 border-x border-b mb-16">
        <div class="lg:col-span-1 p-2 bg-gray-100 font-bold lg:border-r border-y order-1 lg:order-none">Page field</div>
        <div class="lg:col-span-2 p-2 bg-gray-100 font-bold border-y order-3 lg:order-none">Data</div>
        <div class="lg:col-span-1 p-2 lg:border-r order-2 lg:order-none">
            <pre class="w-full">modular-events-column-1</pre>
            <pre class="w-full">modular-events-row-1</pre>
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
@endsection
