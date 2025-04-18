@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('head')
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@1,300;1,400;1,700&display=swap" rel="stylesheet">
@endsection

@section('hero-buttons')
    @include('components/button-row', ['data' => $button_row_1['data'], 'component' => $button_row_1['component']])
@endsection

@section('content')
    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>
@endsection
