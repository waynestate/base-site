@extends('partials.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="row">
        <div class="small-12 large-6 columns">
            @if(!empty($events))
                @include('components.mini-events', ['events' => $events])
            @endif
        </div>
    </div>
@endsection
