@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="row">
        <div class="w-full md:w-1/2">
            @if(!empty($minilist))
                @include('components.mini-list', ['items' => $minilist, 'url' => 'https://wayne.edu', 'heading' => 'Heading'])
            @endif
        </div>
    </div>
@endsection
