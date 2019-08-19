{{--
    $video => array // [['title', 'link', 'relative_url', 'youtube_id', 'excerpt']]
--}}

@if(!empty($video['link']))<a id="video" class="no-underline hover:underline font-bold" href="{{ $video['link'] }}">@endif

    <div class="relative">
        @if(!empty($video['relative_url']))
            @image($video['relative_url'], $video['filename_alt_text'])
        @else
            @image('//i.wayne.edu/youtube/'.$video['youtube_id'].'/max', $video['filename_alt_text'])
        @endif

        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-1/4 opacity-50 transition transition-delay-none transition-timing-ease-in-out hover:opacity-75">
                @svg('video-play')
            </div>
        </div>
    </div>

    @if(!empty($video['title']))
        {!! $video['title'] !!}
    @endif

@if(!empty($video['link']))</a>@endif
