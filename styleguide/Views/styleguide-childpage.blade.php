@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title'], 'class' => $pageTitleClass ?? ''])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>
@endsection
