@extends('layouts.' . (!empty($layout) ? $layout : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

    @if(!empty($articles['data']) || !empty($events))
        <div class="row -mx-4 grid md:grid-cols-2 gap-6">
            @if(!empty($articles['data']))
                <div>
                    <h2>News</h2>
                    @include('components/news-column', ['data' => $articles])
                </div>
            @endif

            @if(!empty($events))
                <div>
                    <h2>Events</h2>
                    @include('components/events-column', ['data' => $events])
                </div>
            @endif
        </div>
    @endif
@endsection
