@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

    <div class="grid grid-cols-2 md:grid-cols-2 items-start gap-y-8 gap-x-4 lg:gap-x-8 mt-8 mb-4">
        @if(!empty($promos))
            @foreach($promos as $group_title => $data)
                @if(!empty($group_title) && !empty($data))
                    @include('components/modular/'.preg_replace('/-\d+$/', '', $group_title), ['data' => $data])
                @endif
            @endforeach
        @endif

        @if(!empty($articles['data']))
            <div class="col-span-2 lg:col-span-1">
                <h2>News</h2>
                @include('components/article-listing', ['articles' => $articles['data'], 'url' => ($base['site']['subsite-folder'] !== null ? $base['site']['subsite-folder'] : '').config('base.news_listing_route').'/'])
            </div>
        @endif

        @if(!empty($events))
            <div class="col-span-2 lg:col-span-1">
                <h2>Events</h2>
                @include('components/events-listing', ['events' => $events, 'cal_name' => !empty($base['site']['events']['path']) ? $base['site']['events']['path'] : null])
            </div>
        @endif
    </div>
@endsection
