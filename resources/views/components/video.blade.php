{{--
    $video => array // [['title', 'link', 'relative_url', 'youtube_id', 'excerpt']]
--}}

@if(!empty($video['link']))<a class="group" href="{{ $video['link'] }}">@endif

    <div class="relative">
        @if(!empty($video['relative_url']))
            @image($video['relative_url'], $video['filename_alt_text'])
        @else
            @image('//i.wayne.edu/youtube/'.$video['youtube_id'].'/max', $video['filename_alt_text'])
        @endif

        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-1/4 opacity-50 group-hover:opacity-75 transition-slow">
                @svg('video-play')
            </div>
        </div>
    </div>

    @if(!empty($video['title']))
        <div class="no-underline group-hover:underline font-bold">
            {!! $video['title'] !!}
        </div>
    @endif

@if(!empty($video['link']))</a>@endif
