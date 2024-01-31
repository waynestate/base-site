{{--
    This component's image is full width on small views
    $item => array // ['title', 'link', 'description', 'excerpt', 'filename_url', 'option']
--}}

<{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="block {{ !empty($component['imageSize']) && $component['imageSize'] === 'small' ? 'flex items-start' : 'md:flex xl:items-center' }} gap-x-3 lg:gap-x-6 {{ !empty($item['link']) ? 'group' : '' }} {{ $loop->iteration > 1 && !empty($component['filename']) && $component['filename'] != 'catalog' ? 'mt-6' : '' }}">
    @if(!empty($item['youtube_id']) || !empty($item['filename_url']))
        <div class="shrink-0 grow-0 {{ !empty($component['imageSize']) && $component['imageSize'] === 'small' ? 'w-1/4' : 'md:w-2/5' }}  
            @if(!empty($component['imagePosition']) && ($component['imagePosition'] === 'right' || ($component['imagePosition'] === 'alternate' && $loop->even))) md:order-2 @endif">
            @if(!empty($item['youtube_id']))
                <div class="play-video-button">
                    @if(!empty($item['filename_url']))
                        @image($item['filename_url'], $item['filename_alt_text'], "w-full lazy")
                    @else
                        @image('//i.wayne.edu/youtube/'.$item['youtube_id'].'/max', $item['title'], "w-full lazy")
                    @endif
                </div>
            @elseif(!empty($item['filename_url']))
                @image($item['filename_url'], $item['filename_alt_text'], "lazy w-full")
            @endif
        </div>
    @endif

    <div class="content w-full">
        @if(!empty($item['youtube_id']) || !empty($item['filename_url']))
            <div class="mb-1 font-bold group-hover:underline group-focus:underline leading-tight text-lg lg:text-xl {{ !empty($component['imageSize']) && $component['imageSize'] === 'small' ? '' : 'mt-2 lg:mt-0' }}">{{ $item['title'] }}</div>
        @elseif (!empty($component['heading']))
            <h3 class="mt-0 mb-3 group-hover:underline group-focus:underline leading-tight">{{ $item['title'] }}</h3>
        @else
            <h2 class="mt-0 group-hover:underline group-focus:underline leading-tight">{{ $item['title'] }}</h2>
        @endif
        <div class="text-black">
            @if(!empty($item['excerpt']))<p class="my-1">{!! strip_tags($item['excerpt'], ['em', 'strong']) !!}</p>@endif 
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
