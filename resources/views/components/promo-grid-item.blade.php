{{--
    This component's image is 1/4 width on small views
    $item => array // ['title', 'link', 'description', 'excerpt', 'relative_url', 'option']
--}}

<{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="block {{ !empty($item['link']) ? 'group' : '' }}">
    @if(!empty($item['youtube_id']))
        <div class="play-video-button w-1/4 shrink-0 md:shrink md:w-full relative bg-green aspect-video">
            @if(!empty($item['relative_url']))
                @image($item['relative_url'], $item['filename_alt_text'], "lazy w-full object-cover h-full")
            @else
                @image('//i.wayne.edu/youtube/'.$item['youtube_id'].'/max', $item['filename_alt_text'], "lazy w-full object-cover h-full")
            @endif
        </div>
    @elseif(!empty($item['relative_url']))
        @image($item['relative_url'], $item['filename_alt_text'], "lazy w-full")
    @endif
    <div class="w-full mt-1 md:mt-2">
        <div class="font-bold text-xl {{ !empty($item['link']) ? 'group-hover:underline group-focus:underline' : '' }}">{{ $item['title'] }}</div>
        @if(!empty($item['excerpt']))<p class="text-black mb-0 mt-1">{!! strip_tags($item['excerpt'], ['em', 'strong']) !!}</p>@endif 
        @if(!empty($item['description']))
            @if (!empty($item['link']))
                <div class="w-full mt-1 -mb-4 text-black">{!! preg_replace(array('"<a href(.*?)>"', '"</a>"'), array('',''), $item['description']) !!}</div>
            @else
                <div class="w-full mt-1 -mb-4 text-black">{!! $item['description'] !!}</div>
            @endif
        @endif
    </div>
<{{ !empty($item['link']) ? '/a' : '/div' }}>


