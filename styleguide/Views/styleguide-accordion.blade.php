@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

    @if(!empty($base['accordion_page']))
        @include('components.accordion', ['data' => $base['accordion_page']])
    @endif

    <h3 class="mt-8">Configuration</h3>
    <div class="grid grid-cols-1 lg:grid-cols-3 border-x border-b">
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

    <h3 class="mt-8">CMS HTML</h3>
<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<ul class="accordion">
    <!-- Item one -->
    <li>
        <a href="#unique-name-1" id="unique-name-1"><span aria-hidden="true"></span>Accordion 1</a>
        <div class="content">
            <p>Panel 1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </li>

    <!-- Item two -->
    <li>
        <a href="#unique-name-2" id="unique-name-2"><span aria-hidden="true"></span>Accordion 2</a>
        <div class="content">
            <p>Panel 2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </li>

    <!-- Item three -->
    <li>
        <a href="#unique-name-3" id="unique-name-3"><span aria-hidden="true"></span>Accordion 3</a>
        <div class="content">
            <p>Panel 3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </li>
</ul>') !!}
</pre>
@endsection
