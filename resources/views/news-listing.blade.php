@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="news-listing">
        <dl>
            @forelse($news as $news_item)
                <dt class="mb-1">
                    <a href="{{ $news_item['full_link'] }}">
                        {{ $news_item['title'] }}
                    </a>
                </dt>

                <dd class="mb-2 pb-2 border-b border-grey-lighter">
                    <time class="block text-sm text-grey-darker" datetime="{{ $news_item['posted'] }}">{{ apdatetime(date('F j, Y', strtotime($news_item['posted']))) }}</time>
                    {{ $news_item['excerpt'] }}
                </dd>
            @empty
                <p>Currently there are no news items {{ !empty($selected_news_category['category']) ? ' for the category ' . strtolower($selected_news_category['category']) : '' }}.</p>
            @endforelse
        </dl>

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
    </div>
@endsection

@section('below_menu')
    @if(!empty($news_categories))
        @include('components.news-categories', ['categories' => $news_categories, 'selected_category' => $selected_news_category])
    @endif
@endsection
