@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    @if(!empty($paginate) && !empty($paginate->items()))
        <ul>
            @foreach($paginate->items() as $article)
                <li class="mb-3 pb-4 border-b border-gray-200">
                    <a href="{{ $article['link'] }}" class="font-bold text-lg block">
                        {{ $article['title'] }}
                    </a>
                    <time class="block text-sm text-gray-500 mt-1 leading-tight" datetime="{{ $article['article_date'] }}">{{ apdatetime(date('F j, Y', strtotime($article['article_date']))) }}</time>
                </li>
            @endforeach
        </ul>

        @include('components.paginator')
    @else
        <p>Currently there are no articles{{ !empty($topic['data']['name']) ? ' for the category ' . strtolower($topic['data']['name']) : '' }}.</p>
    @endif
@endsection

@section('below_menu')
    @if(!empty($topics['data']))
        @include('components.article-topics', ['topics' => $topics['data'], 'heading' => config('base.news_topics_text')])
    @endif
@endsection
