@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $article['data']['title']])

    <div class="news-item">
        <time class="block text-sm text-gray-500 mb-6" datetime="{{ $article['data']['article_date'] }}">{{ apdatetime(date('F j, Y', strtotime($article['data']['article_date']))) }}</time>

        <div class="sharethis-inline-share-buttons mb-4 print:hidden"></div>

        <div class="content mt:text-xl">
            {!! $article['data']['body'] !!}

            @if(!empty($article['data']['faculty']))
                <h2 class="border-b mt-4">Faculty spotlight</h2>

                <ul>
                    @foreach($article['data']['faculty'] as $faculty)
                        <li>
                            <a href="https://wayne.edu/people/{{ $faculty['accessid'] }}">
                                {{ $faculty['first_name'] }} {{ $faculty['last_name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if(!empty($article['data']['assets']))
                <h2 class="border-b mt-4">Assets</h2>

                <ul>
                    @foreach($article['data']['assets'] as $asset)
                        <li>
                            <a href="{{ $asset['url'] }}">{{ !empty($asset['caption']) ? $asset['caption'] . ' ('.pathinfo($asset['filename'])['extension'].')' : basename($asset['filename']) }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <p class="pt-4 print:hidden">
            <a href="/{{ ($base['site']['subsite-folder'] !== null) ? $base['site']['subsite-folder'] : '' }}{{ config('base.news_listing_route') }}" class="button">&larr; Back to listing</a>
        </p>
    </div>
@endsection

@section('below_menu')
    @if(!empty($topics['data']))
        @include('components.article-topics', ['topics' => $topics['data'], 'heading' => config('base.news_topics_text')])
    @endif
@endsection
