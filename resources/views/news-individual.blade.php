@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $news['title'] }}</h1>

    <div class="news-item">
        <time datetime="{{ $news['posted'] }}">{{ apdatetime(date('F j, Y', strtotime($news['posted']))) }}</time>

        {!! $news['body'] !!}

        <p rel="back">
            <a rel="back" href="/{{ ($site['subsite-folder'] !== null) ? $site['subsite-folder'] : '' }}news">Back to listing</a>
        </p>
    </div>
@endsection

@section('below_menu')
    @include('components.news-categories', ['categories' => $news_categories, 'selected_category' => $selected_news_category])
@endsection
