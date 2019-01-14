@extends('components.content-area')

@section('content')
    <div class="float-right mt-4 mr-4">
        <a href="/{{ config('base.news_listing_route') }}/{{ config('base.news_topics_route') }}/" class="button">{{ config('base.news_topics_text') }}</a>
    </div>

    @include('components.page-title', ['title' => $page['title']])

    <ul class="list-reset">
        @forelse($articles['data'] as $article)
            <li class="mb-3 pb-4 border-b border-grey-lighter">
                <a href="{{ $article['link'] }}" class="font-bold text-lg block">
                    {{ $article['title'] }}
                </a>
                <time class="block text-sm text-grey-darker mt-1 leading-tight" datetime="{{ $article['article_date'] }}">{{ apdatetime(date('F j, Y', strtotime($article['article_date']))) }}</time>
            </li>

        @empty
            <p>Currently there are no news items {{ !empty($topic['data']['name']) ? ' for the category ' . strtolower($topic['data']['name']) : '' }} {{ config('base.news_topic_route') }}.</p>
        @endforelse
    </ul>

    @if(!empty($paging))
        <div class="row flex -mx-4">
            <div class="w-1/2 px-4">
                @if(count($news) == $paging['perPage'])
                    <p>
                        <a href="{{ app('request')->url() }}?page={{ $paging['page_number_previous'] }}">&larr; Previous</a>
                    </p>
                @endif
            </div>

            <div class="w-1/2 px-4 text-right">
                @if($paging['page_number_next'] >= 0)
                    <p>
                        <a href="{{ app('request')->url() }}?page={{ $paging['page_number_next'] }}">Next &rarr;</a>
                    </p>
                @endif
            </div>
        </div>
    @endif
@endsection

@section('below_menu')
    @if(!empty($news_categories))
        @include('components.news-categories', ['categories' => $news_categories, 'selected_category' => $selected_news_category])
    @endif
@endsection
