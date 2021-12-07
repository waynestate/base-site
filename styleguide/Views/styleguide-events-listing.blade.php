@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
    <p>Events can be a half-sized column usually placed next to news, or take up the whole row in two columns.</p>

    <h3>Options to customize this component</h3>
    <ul>
        <li>Which calendar the events come from</li>
        <li>Specify where the "More events" button links to</li>
        <li>Change what the "More events" button says</li>
        <li>Choose a different button style</li>
    </ul>
    </div>

    <div class="mt-8 md:w-1/2">
        <h2>Events standard listing</h2>
        @if(!empty($events))
            @include('components.events-listing', ['events' => $events])
        @endif
    </div>

    <div class="w-full mt-8">
        <h2>Events in two columns</h2>
        @if(!empty($events))
            @include('components.events-listing-full-width', ['events' => $events])
        @endif
    </div>
@endsection
