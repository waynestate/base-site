{{--
    This component's image is 1/4 width on small views
    $item => array // ['title', 'link', 'description', 'excerpt', 'relative_url', 'option']
--}}

<{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="flex items-start space-x-3 md:space-x-0 md:block {{ !empty($item['link']) ? 'group' : '' }}">
    @if(!empty($item['youtube_id']))
        <div class="play-video-button w-1/4 shrink-0 md:shrink md:w-full relative bg-green aspect-video">
            @if(!empty($item['relative_url']))
                @image($item['relative_url'], $item['filename_alt_text'], "lazy w-1/4 shrink-0 md:shrink md:w-full object-cover h-full")
            @else
                @image('//i.wayne.edu/youtube/'.$item['youtube_id'].'/max', $item['filename_alt_text'], "lazy w-1/4 shrink-0 md:shrink md:w-full object-cover h-full")
            @endif
        </div>
    @else
        @image($item['relative_url'], $item['filename_alt_text'], "lazy w-1/4 shrink-0 md:shrink md:w-full")
    @endif
    <div class="w-full relative md:pt-2">
        <div class="font-bold text-xl group-hover:underline group-focus:underline">{{ $item['title'] }}</div>
        @if(!empty($item['excerpt']))<p class="text-base text-black mb-0 mt-1">{{ $item['excerpt'] }}</p>@endif
        @if(!empty($item['description']))
            @if (!empty($item['link']))
                <div class="w-full text-black mt-1">{!! preg_replace(array('"<a href(.*?)>"', '"</a>"'), array('',''), $item['description']) !!}</div>
            @else
                <div class="w-full text-black mt-1">{!! $item['description'] !!}</div>
            @endif
        @endif
    </div>
<{{ !empty($item['link']) ? '/a' : '/div' }}>


