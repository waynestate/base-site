{{--
    $item => array // ['title', 'link', 'description', 'excerpt', 'relative_url', 'option']
--}}

<div class="sm:flex items-start sm:space-x-6 mb-8 mt-4">
    @if(!empty($item['relative_url']))
        @image($item['relative_url'], $item['filename_alt_text'], 'sm:w-1/4 sm:shrink-0')
    @endif

    <div class="md:mt-0 content">
        <h3 class="mt-0 mb-2">
            @if(!empty($item['link']))<a href="{{ $item['link'] }}">@endif
                {{ $item['title'] }}
            @if(!empty($item['link']))</a>@endif
        </h3>
        @if(!empty($item['excerpt']))
            <div class="text-black mb-1">
                {{ $item['excerpt'] }}
            </div>
        @endif
        @if(!empty($item['description']))
            <div class="text-black">
                {!! $item['description'] !!}
            </div>
        @endif
    </div>
</div>
