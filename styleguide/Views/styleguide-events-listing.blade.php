@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="row">
        <div class="w-full md:w-1/2">
            @if(!empty($events))
                @include('components.events-listing', ['events' => $events])
            @endif
        </div>
    </div>
@endsection
