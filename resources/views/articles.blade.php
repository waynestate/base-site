@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    @if(!empty($articles['data']))
        <ul class="list-reset">
            @foreach($articles['data'] as $article)
                <li class="mb-3 pb-4 border-b border-grey-lighter">
                    <a href="{{ $article['link'] }}" class="font-bold text-lg block">
                        {{ $article['title'] }}
                    </a>
                    <time class="block text-sm text-grey-darker mt-1 leading-tight" datetime="{{ $article['article_date'] }}">{{ apdatetime(date('F j, Y', strtotime($article['article_date']))) }}</time>
                </li>
            @endforeach
        </ul>
    @else
        <p>Currently there are no articles {{ !empty($topic['data']['name']) ? ' for the category ' . strtolower($topic['data']['name']) : '' }} {{ config('base.news_topic_route') }}.</p>
    @endif

    @if(!empty($articles['meta']['prev_page_url']) || !empty($articles['meta']['next_page_url']))
        <div class="row flex -mx-4">
            <div class="w-1/2 px-4">
                @if(!empty($articles['meta']['prev_page_url']))
                    <p>
                        <a href="{{ $articles['meta']['prev_page_url'] }}">&larr; Previous</a>
                    </p>
                @endif
            </div>

            <div class="w-1/2 px-4 text-right">
                @if(!empty($articles['meta']['next_page_url']) && $articles['meta']['current_page'] !== 1)
                    <p>
                        <a href="{{ $articles['meta']['next_page_url'] }}">Next &rarr;</a>
                    </p>
                @endif
            </div>
        </div>
    @endif
@endsection
