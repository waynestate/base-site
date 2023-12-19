{{--
    This component's image is full width on small views
    $item => array // ['title', 'link', 'description', 'excerpt', 'relative_url', 'option']
--}}

<{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} 
class="{{ !empty($component['imageSize']) && $component['imageSize'] === 'small' ? 'flex items-start' : 'md:flex items-center' }} gap-x-3 lg:gap-x-6 {{ !empty($item['link']) ? 'group' : '' }}">
    <div class="shrink-0 grow-0 {{ !empty($component['imageSize']) && $component['imageSize'] === 'small' ? 'w-1/4' : 'md:w-2/5' }}  
        @if(!empty($component['imagePosition']) && ($component['imagePosition'] === 'right' || ($component['imagePosition'] === 'alternate' && $loop->even))) md:order-2 @endif">
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
        <div class="font-bold group-hover:underline group-focus:underline {{ !empty($component['imageSize']) && $component['imageSize'] === 'small' ? 'text-lg lg:text-xl' : 'text-xl lg:text-2xl ' }}">{{ $item['title'] }}</div>
        <div class="text-black mt-1 {{ !empty($component['imageSize']) && $component['imageSize'] === 'small' ? 'text-sm lg:text-base' : 'text-base' }}">
            @if(!empty($item['excerpt']))
                <p>{!! strip_tags($item['excerpt'], ['em', 'strong']) !!}</p>
            @endif
            @if(!empty($item['description']))
                @if (!empty($item['link']))
                    <div>{!! preg_replace(array('"<a href(.*?)>"', '"</a>"'), array('',''), $item['description']) !!}</div>
                @else
                    <div>{!! $item['description'] !!}</div>
                @endif
            @endif
        </div>
    </div>
<{{ !empty($item['link']) ? '/a' : '/div' }}>
