@extends('partials.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        {!! $page['content']['main'] !!}
    </div>

    @if(!empty($accordion_page))
        @include('components.accordion', ['items' => $accordion_page])
    @endif
@endsection
