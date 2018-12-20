@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $news['title']])

    <div class="news-item">

        <time class="block text-sm text-grey-darker mb-6" datetime="{{ $news['posted'] }}">{{ apdatetime(date('F j, Y', strtotime($news['posted']))) }}</time>

        <div class="addthis_sharing_toolbox mb-4"></div>

        <div class="content mt:text-xl">
            {!! $news['body'] !!}
        </div>

        <p class="pt-4">
            <a href="/{{ ($site['subsite-folder'] !== null) ? $site['subsite-folder'] : '' }}{{ config('base.news_listing_route') }}">Back to listing</a>
        </p>
    </div>
@endsection

@section('below_menu')
    @include('components.news-categories', ['categories' => $news_categories, 'selected_category' => $selected_news_category])
@endsection
