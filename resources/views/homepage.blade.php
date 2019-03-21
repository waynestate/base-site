@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        {!! $page['content']['main'] !!}
    </div>

    @if(!empty($articles['data']) || !empty($events))
        <div class="row -mx-4 flex flex-wrap">
            @if(!empty($articles['data']))
                <div class="w-full md:w-1/2 px-4">
                    @include('components/article-listing', ['articles' => $articles['data'], 'url' => ($site['subsite-folder'] !== null ? $site['subsite-folder'] : '').config('base.news_listing_route').'/'])
                </div>
            @endif

            @if(!empty($events))
                <div class="w-full md:w-1/2 px-4">
                    @include('components/events-listing', ['events' => $events, 'cal_name' => !empty($site['events']['path']) ? $site['events']['path'] : null])
                </div>
            @endif
        </div>
    @endif
@endsection
