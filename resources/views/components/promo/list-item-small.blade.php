{{--
    This component's image is 1/4 width on small views
    $item => array // ['title', 'link', 'description', 'excerpt', 'relative_url', 'option']
--}}

<{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class=" flex items-start space-x-3 md:space-x-6 mb-8 {{ !empty($item['link']) ? 'group' : '' }}">
    @if(!empty($item['youtube_id']))
        <div class="play-video-button w-1/4 shrink-0">
            @if(!empty($item['filename_url']))
                @image($item['filename_url'], $item['filename_alt_text'], "lazy w-1/4 shrink-0")
            @else
                @image('//i.wayne.edu/youtube/'.$item['youtube_id'].'/max', $item['filename_alt_text'], "lazy w-1/4 shrink-0")
            @endif
        </div>
    @elseif(!empty($item['filename_url']))
        @image($item['filename_url'], $item['filename_alt_text'], "lazy w-1/4 shrink-0")
    @endif

    <div class="md:mt-0 content">
        <div class="font-bold text-xl group-hover:underline group-focus:underline">{{ $item['title'] }}</div>
        @if(!empty($item['excerpt']))
            <div class="text-black mt-1">
                {!! strip_tags($item['excerpt'], ['em', 'strong']) !!}
            </div>
        @endif
        @if(!empty($item['description']))
            @if (!empty($item['link']))
                <div class="text-black mt-1">{!! preg_replace(array('"<a href(.*?)>"', '"</a>"'), array('',''), $item['description']) !!}</div>
            @else
                <div class="text-black mt-1">{!! $item['description'] !!}</div>
            @endif
        @endif
    </div>
<{{ !empty($item['link']) ? '/a' : '/div' }}>
