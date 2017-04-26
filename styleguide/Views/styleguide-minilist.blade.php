@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $page['title'] }}</h1>

    <div class="row">
        <div class="medium-6 columns">
            @if(isset($minilist))
                @include('components.mini-list', ['items' => $minilist, 'url' => 'http://wayne.edu/', 'heading' => 'Heading'])
            @endif
        </div>
    </div>
@endsection
