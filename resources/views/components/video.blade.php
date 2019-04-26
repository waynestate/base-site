{{--
    $video => array // [['title', 'link', 'relative_url', 'youtube_id', 'excerpt']]
--}}

<div class="w-full px-4">
    @if(!empty($video['link']))<a class="no-underline hover:underline font-bold" href="{{ $video['link'] }}">@endif

        <div class="relative">
            @if(!empty($video['relative_url']))
                @image($video['relative_url'], $video['excerpt'])
            @else
                @image('//i.wayne.edu/youtube/'.$video['youtube_id'].'/max')
            @endif

            <div class="absolute pin flex items-center justify-center">
                <div class="w-1/4 opacity-50 transition transition-delay-none transition-timing-ease-in-out hover:opacity-75">
                    @svg('video-play')
                </div>
            </div>
        </div>

        @if(!empty($video['title']))
            {!! $video['title'] !!}
        @endif

    @if(!empty($video['link']))</a>@endif
</div>
