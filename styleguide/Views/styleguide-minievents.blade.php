@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $page['title'] }}</h1>

    <div class="row">
        <div class="small-12 large-6 columns">
            @if(isset($events))
                @include('components.mini-events', ['events' => $events])
            @endif
        </div>
    </div>
@endsection
