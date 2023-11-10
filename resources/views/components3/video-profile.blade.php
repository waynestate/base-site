{{--
    $video => array // [['title', 'link', 'relative_url', 'youtube_id']]
--}}

<div>
    <a href="{{ $video['link'] }}">
        @image('//i.wayne.edu/youtube/'.$video['youtube_id'], $video['filename_alt_text'], "lazy")
    </a>
</div>
