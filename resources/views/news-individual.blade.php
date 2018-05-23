@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $news['title']])

    <div class="news-item">
        <div class="addthis_share">Share</div>
        <div class="addthis_sharing_toolbox"></div>

        <time class="block text-sm text-grey-darker mb-2" datetime="{{ $news['posted'] }}">{{ apdatetime(date('F j, Y', strtotime($news['posted']))) }}</time>

        <div class="content">
            {!! $news['body'] !!}
        </div>

        <p rel="back" class="pt-4">
            <a rel="back" href="/{{ ($site['subsite-folder'] !== null) ? $site['subsite-folder'] : '' }}news">Back to listing</a>
        </p>
    </div>
@endsection

@section('below_menu')
    @include('components.news-categories', ['categories' => $news_categories, 'selected_category' => $selected_news_category])
@endsection
