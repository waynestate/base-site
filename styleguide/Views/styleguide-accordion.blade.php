@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

    @if(!empty($base['accordion_page']))
        @include('components.accordion', ['items' => $base['accordion_page']])
    @endif

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
