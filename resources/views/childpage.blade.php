@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $page['title'] }}</h1>

    {!! $page['content']['main'] !!}

    @if(isset($accordion_page) && count($accordion_page) > 0)
        @include('components.accordion', ['items' => $accordion_page])
    @endif
@endsection
