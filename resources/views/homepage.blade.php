@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        {!! $page['content']['main'] !!}
    </div>

    @if(!empty($news) || !empty($events))
        <div class="row -mx-4 flex flex-wrap">
            @if(!empty($news))
                <div class="w-full md:w-1/2 px-4">
                    @include('components/mini-news', ['news' => $news, 'url' => ($site['subsite-folder'] !== null ? $site['subsite-folder'] : '').config('base.news_listing_route').'/'])
                </div>
            @endif

            @if(!empty($events))
                <div class="w-full md:w-1/2 px-4">
                    @include('components/mini-events', ['events' => $events])
                </div>
            @endif
        </div>
    @endif
@endsection
