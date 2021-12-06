@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <p>Events can be a half-sized column usually placed next to news, or take up the whole row in two columns.</p>

    <div class="w-full md:w-1/2">
        <h2>Events standard listing</h2>
        @if(!empty($events))
            @include('components.events-listing', ['events' => $events])
        @endif
    </div>

    <div class="w-full mt-8">
        <h2>Events in two columns</h2>
        @if(!empty($events))
            @include('components.events-listing-full-width', ['events' => $events, 'heading'=> 'bg-gold'])
        @endif
    </div>
@endsection
