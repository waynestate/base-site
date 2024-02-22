@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    @if(!empty($articles['data']))
        <ul>
            @foreach($articles['data'] as $article)
                <li class="mb-3 pb-4 border-b border-gray-200">
                    <a href="{{ $article['link'] }}" class="font-bold text-lg block">
                        {{ $article['title'] }}
                    </a>
                    <time class="block text-sm text-gray-500 mt-1 leading-tight" datetime="{{ $article['article_date'] }}">{{ apdatetime(date('F j, Y', strtotime($article['article_date']))) }}</time>
                </li>
            @endforeach
        </ul>
    @else
        <p>Currently there are no articles{{ !empty($topic['data']['name']) ? ' for the category ' . strtolower($topic['data']['name']) : '' }}.</p>
    @endif

    @if(!empty($articles['meta']['prev_page_url']) || !empty($articles['meta']['next_page_url']))
        <div class="row flex -mx-4">
            <div class="w-1/2 px-4">
                @if(!empty($articles['meta']['prev_page_url']))
                    <p>
                        <a href="{{ $articles['meta']['prev_page_url'] }}" class="button">&larr; Previous</a>
                    </p>
                @endif
            </div>

            <div class="w-1/2 px-4 text-right">
                @if(!empty($articles['meta']['next_page_url']) && $articles['meta']['current_page'] !== 1)
                    <p>
                        <a href="{{ $articles['meta']['next_page_url'] }}" class="button">Next &rarr;</a>
                    </p>
                @endif
            </div>
        </div>
    @endif
@endsection

@section('below_menu')
    @if(!empty($topics['data']))
        @include('components.article-topics', ['topics' => $topics['data'], 'heading' => config('base.news_topics_text')])
    @endif
@endsection
