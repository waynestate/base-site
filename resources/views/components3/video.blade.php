{{--
    $video => array // [['title', 'link', 'relative_url', 'youtube_id', ]]
    $title_class => 'font-bold' 
--}}

<div>
    <a class="play-video-button" href="{{ $video['link'] }}">
        @if(!empty($video['relative_url']))
            @image($video['relative_url'], $video['filename_alt_text'], "lazy")
        @else
            @image('//i.wayne.edu/youtube/'.$video['youtube_id'].'/max', $video['filename_alt_text'], "lazy")
        @endif
    </a>

    <p class="my-2 {{ $title_class ?? '' }}">{{ $video['title'] }}</p>
</div>
