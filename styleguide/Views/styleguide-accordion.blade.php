@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

    @if(!empty($base['accordion_page']))
        @include('components.accordion', ['items' => $base['accordion_page']])
    @endif

    <pre class="bg-grey-lightest overflow-scroll p-4" tabindex="0">
    {!! htmlspecialchars('
<ul class="accordion">
    <li>
        <a href="#panel1a" id="panel1a"><span aria-hidden="true"></span>Accordion 1</a>
        <div class="content">
            <p>Panel 1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </li>
    <li>
        <a href="#panel2a" id="panel2a"><span aria-hidden="true"></span>Accordion 2</a>
        <div class="content">
            <p>Panel 2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </li>
    <li>
        <a href="#panel3a" id="panel3a"><span aria-hidden="true"></span>Accordion 3</a>
        <div class="content">
            <p>Panel 3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </li>
</ul>') !!}
    </pre>
@endsection
