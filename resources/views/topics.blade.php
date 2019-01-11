@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        {!! $page['content']['main'] !!}
    </div>

    @foreach($topics as $letter => $topics)
        <div class="mb-6">
            <h2 class="heading-lined text-center text-green">{{$letter}}</h2>
            <div class="flex flex-wrap">
                @foreach($topics as $topic)
                    <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 mb-6"><a href="/{{ config('base.news_listing_route') }}/{{ config('base.news_topic_route') }}/{{$topic['slug']}}">{{$topic['name']}}</a></div>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
