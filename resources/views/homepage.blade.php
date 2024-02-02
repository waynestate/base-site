@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

    @if(!empty($articles['data']) || !empty($events))
        <div class="row md:flex gap-4 xl:gap-8">
            @if(!empty($articles['data']))
                <div class="lg:w-1/2">
                    <h2>News</h2>
                    @include('components/news-column', ['data' => $articles, 'url' => ($base['site']['subsite-folder'] !== null ? $base['site']['subsite-folder'] : '').config('base.news_listing_route').'/'])
                </div>
            @endif

            @if(!empty($events))
                <div class="lg:w-1/2">
                    <h2>Events</h2>
                    @include('components/events-column', ['data' => $events, 'cal_name' => !empty($base['site']['events']['path']) ? $base['site']['events']['path'] : null])
                </div>
            @endif
        </div>
    @endif
@endsection
