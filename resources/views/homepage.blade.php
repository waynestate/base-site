@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $page['title'] }}</h1>

    {!! $page['content']['main'] !!}
@endsection
