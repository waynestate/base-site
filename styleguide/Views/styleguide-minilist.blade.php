@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $page['title'] }}</h1>

    <div class="row">
        <div class="small-12 large-6 columns">
            @if(!empty($minilist))
                @include('components.mini-list', ['items' => $minilist, 'url' => 'https://wayne.edu/', 'heading' => 'Heading'])
            @endif
        </div>
    </div>
@endsection
