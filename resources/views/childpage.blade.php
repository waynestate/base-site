@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

    @if(!empty($base['accordion_page']))
        @include('components.accordion', ['items' => $base['accordion_page']])
    @endif
@endsection
