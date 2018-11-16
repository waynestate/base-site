@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <ul class="list-reset">
        @forelse($news as $news_item)
            <li class="mb-3 pb-4 border-b border-grey-lighter">
                <a href="{{ $news_item['full_link'] }}" class="font-bold text-lg block">
                    {{ $news_item['title'] }}
                </a>
                @if(!empty($news_item['excerpt']))<div class="text-sm mt-1 mb-2 leading-tight">{{ $news_item['excerpt'] }}</div>@endif
                <time class="block text-sm text-grey-darker mt-1 leading-tight" datetime="{{ $news_item['posted'] }}">{{ apdatetime(date('F j, Y', strtotime($news_item['posted']))) }}</time>
            </li>

        @empty
            <p>Currently there are no news items {{ !empty($selected_news_category['category']) ? ' for the category ' . strtolower($selected_news_category['category']) : '' }}.</p>
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
