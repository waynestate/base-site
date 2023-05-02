{{--
    $item => array // ['title', 'link', 'description', 'excerpt', 'relative_url', 'option']
--}}

<div>
    @if(!empty($item['relative_url']))
        @image($item['relative_url'], $item['filename_alt_text'], 'w-full mb-2')
    @endif

    <div class="mt-2 md:mt-0 content">
        <h3 class="text-xl mt-0 mb-2">
            @if(!empty($item['link']))<a href="{{ $item['link'] }}" class="group">@endif
            {{ $item['title'] }}
            @if(!empty($item['link']))</a>@endif
        </h3>
        @if(!empty($item['description']))
            <div class="text-black">
                {!! $item['description'] !!}
            </div>
        @endif
    </div>
</div>
