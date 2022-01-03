@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
    </div>

    @if(!empty($promos))
        <ul class="mt-8">
            @foreach($promos as $item)
                <li class="flex flex-wrap sm:flex-no-wrap mb-8 pb-8 @if(!$loop->last) border-b border-gray-200 @endif -mx-4">
                    @if(!empty($item['relative_url']))
                        <div class="w-full sm:w-1/3 md:w-1/5 mb-3 sm:mb-0 px-4">
                            @image($item['relative_url'], $item['filename_alt_text'], 'w-full')
                        </div>
                    @endif
                    <div class="px-4 w-full md:w-4/5 content">
                        @if(!empty($item['link']))
                            <a href="{{ $item['link'] }}" class="block font-bold text-lg mb-2">{{ $item['title'] }}</a>
                        @else
                            <div class="font-bold text-lg mb-2">{{ $item['title'] }}</div>
                        @endif

                        @if(!empty($item['excerpt']))
                            <div class="mb-2">{{ $item['excerpt'] }}</div>
                        @endif

                        @if(!empty($item['description']))
                            <div>{!! $item['description'] !!}</div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    @if(!empty($pages))
        <div class="flex justify-center">
            <a href="?page={{ $pages['prev_page'] }}" class="mx-4 button w-1/2 lg:w-1/5">&larr; &nbsp; Previous</a>
            @if($pages['next_page'] != null || $pages['next_page'] === 0)
                <a href="?page={{ $pages['next_page'] }}" class="mx-4 button w-1/2 lg:w-1/5">Next &nbsp; &rarr;</a>
            @endif
        </div>
    @endif
@endsection
