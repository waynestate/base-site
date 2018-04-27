@extends('partials.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="row px-4">
        <div class="w-full md:w-1/2">
            @if(!empty($events))
                @include('components.mini-events', ['events' => $events])
            @endif
        </div>
    </div>
@endsection
