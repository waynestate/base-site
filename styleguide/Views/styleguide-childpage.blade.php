@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title'], 'class' => $pageTitleClass ?? ''])

    <div class="content">
        {!! $page['content']['main'] !!}
    </div>
@endsection
