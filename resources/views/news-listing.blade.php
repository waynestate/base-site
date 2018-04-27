@extends('partials.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="news-listing">
        <dl>
            @forelse($news as $news_item)
                <dt>
                    <a href="/{{ ($site['subsite-folder'] !== null) ? $site['subsite-folder'] : '' }}news/{{ $news_item['slug'] }}-{{ $news_item['news_id'] }}">
                        {{ $news_item['title'] }}
                    </a>
                </dt>

                <dd>
                    <time datetime="{{ $news_item['posted'] }}">{{ apdatetime(date('F j, Y', strtotime($news_item['posted']))) }}</time>
                    {{ $news_item['excerpt'] }}
                </dd>
            @empty
                <p>Currently there are no news items {{ isset($selected_news_category['category']) ? ' for the category ' . strtolower($selected_news_category['category']) : '' }}.</p>
            @endforelse
        </dl>

        @if(!empty($paging))
            <div class="row flex p-4">
                <div class="w-1/2">
                    @if(count($news) == $paging['perPage'])
                        <p>
                            <a href="{{ app('request')->url() }}?page={{ $paging['page_number_previous'] }}">&larr; Previous</a>
                        </p>
                    @endif
                </div>

                <div class="w-1/2 text-right">
                    @if($paging['page_number_next'] >= 0)
                        <p>
                            <a href="{{ app('request')->url() }}?page={{ $paging['page_number_next'] }}">Next &rarr;</a>
                        </p>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection

@section('below_menu')
    @if(!empty($news_categories))
        @include('components.news-categories', ['categories' => $news_categories, 'selected_category' => $selected_news_category])
    @endif
@endsection
