@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        {!! $page['content']['main'] !!}
    </div>

    @if(!empty($promos))
        <ul class="flex flex-wrap -mx-4">
            @foreach($promos as $item)
                <li class="w-full md:w-1/2 xl:w-1/3 px-4 pb-6">
                    @if(!empty($item['link']))<a href="{{ $item['link'] }}" class="group">@endif
                        <div class="flex md:block">
                            <div class="w-1/3 md:w-full">
                                @image($item['relative_url'], $item['filename_alt_text'], 'block')
                            </div>
                            <div class="w-2/3 pl-4 md:p-0 md:w-full">
                                <div class="font-bold mt-1 lg:mt-2 {{ (!empty($item['link']) ? 'underline group-hover:no-underline' : '') }}">{{ $item['title'] }}</div>
                                <p class="text-sm text-black">{{ $item['excerpt'] }}</p>
                            </div>
                        </div>
                    @if(!empty($item['link']))</a>@endif
                </li>
            @endforeach
        </ul>
    @endif

@endsection
