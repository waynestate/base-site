@extends('partials.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="row">
        <div class="small-12 large-6 columns">
            @if(!empty($minilist))
                @include('components.mini-list', ['items' => $minilist, 'url' => 'https://wayne.edu/', 'heading' => 'Heading'])
            @endif
        </div>
    </div>
@endsection
