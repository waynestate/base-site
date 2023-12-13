{{--
    This component's image is full width on small views
    $item => array // ['title', 'link', 'description', 'excerpt', 'relative_url', 'option']
--}}

<{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="md:flex items-center gap-x-3 lg:gap-x-6 mb-8 {{ !empty($item['link']) ? 'group' : '' }}">
    <div class="md:w-1/2 shrink-0 grow-0 @if(!empty($component['imagePosition']) && $component['imagePosition'] === 'right') md:order-2 @endif">
        @if(!empty($item['youtube_id']))
            <div class="play-video-button">
                @if(!empty($item['relative_url']))
                    @image($item['relative_url'], $item['filename_alt_text'], "w-full lazy")
                @else
                    @image('//i.wayne.edu/youtube/'.$item['youtube_id'].'/max', $item['filename_alt_text'], "w-full lazy")
                @endif
            </div>
        @elseif(!empty($item['relative_url']))
            @image($item['relative_url'], $item['filename_alt_text'], "lazy w-full")
        @endif
    </div>

    <div class="content">
        <div class="font-bold text-xl lg:text-2xl mt-2 lg:mt-0 group-hover:underline group-focus:underline">{{ $item['title'] }}</div>
        @if(!empty($item['excerpt']))
            <div class="text-black mt-1">{!! strip_tags($item['excerpt'], ['em', 'strong']) !!}</div>
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
