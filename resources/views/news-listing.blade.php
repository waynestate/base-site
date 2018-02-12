@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $page['title'] }}</h1>

    <div class="news-listing">
        <dl>
            @foreach($news as $news_item)
                <dt>

                    <a href="/{{ ($site['subsite-folder'] !== null) ? $site['subsite-folder'] : '' }}news/{{ $news_item['slug'] }}-{{ $news_item['news_id'] }}">
                        {{ $news_item['title'] }}
                    </a>
                </dt>

                <dd>
                    <time datetime="{{ $news_item['posted'] }}">{{ apdatetime(date('F j, Y', strtotime($news_item['posted']))) }}</time>
                    {{ $news_item['excerpt'] }}
                </dd>
            @endforeach

            @if(count($news) == 0)
                <p>Currently there are no news items {{ isset($selected_news_category['category']) ? ' for the category ' . strtolower($selected_news_category['category']) : '' }}.</p>
            @endif
        </dl>

        <div class="row">
            <div class="small-6 columns">
                @if(count($news) == $paging['perPage'])
                    <p>
                        <a href="{{ app('request')->url() }}?page={{ $paging['page_number_previous'] }}">&larr; Previous</a>
                    </p>
                @endif
            </div>

            <div class="small-6 columns text-right">
                @if($paging['page_number_next'] >= 0)
                    <p>
                        <a href="{{ app('request')->url() }}?page={{ $paging['page_number_next'] }}">Next &rarr;</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('below_menu')
    @include('components.news-categories', ['categories' => $news_categories, 'selected_category' => $selected_news_category])
@endsection
