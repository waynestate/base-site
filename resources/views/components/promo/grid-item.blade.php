{{--
    This component's image is 1/4 width on small views
    $item => array // ['title', 'link', 'description', 'excerpt', 'relative_url', 'option']
--}}

<{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="block {{ !empty($component['gradientOverlay']) && $component['gradientOverlay'] === true ? 'bg-green-800 relative overflow-hidden' : '' }} {{ !empty($item['link']) ? 'group' : '' }}">
    @if(!empty($item['youtube_id']))
        <div class="play-video-button">
            @if(!empty($item['relative_url']))
                @image($item['relative_url'], $item['filename_alt_text'], "lazy block w-full")
            @else
                @image('//i.wayne.edu/youtube/'.$item['youtube_id'].'/max', $item['filename_alt_text'], "lazy block w-full")
            @endif
        </div>
    @elseif(!empty($item['relative_url']))
        @image($item['relative_url'], $item['filename_alt_text'], "lazy block w-full")
    @endif
    <div class="w-full {{ !empty($component['gradientOverlay']) && $component['gradientOverlay'] === true ? 'bg-gradient-darkest absolute inset-x-0 bottom-0' : 'mt-2'}}">
        <div class="content {{ !empty($component['gradientOverlay']) && $component['gradientOverlay'] === true ? 'white-links text-white relative p-4 pb-3 pt-14 drop-shadow-px' : '' }}">
            <div class="mb-1 font-bold {{ !empty($component['columns']) ? ($component['columns'] < 4 ? 'text-lg' : 'text-base') : 'text-xl' }} {{ !empty($item['link']) ? 'group-hover:underline group-focus:underline' : '' }} leading-snug xl:leading-tight">
                {{ $item['title'] }}
            </div>
            <div class="{{ !empty($component['columns']) ? ($component['columns'] < 4 ? ($component['columns'] < 3 ? 'text-base md:text-base leading-tight sm:leading-tight md:leading-tight' : 'text-base md:text-sm xl:text-base leading-normal') : 'text-sm') : 'text-base leading-normal' }} {{ !empty($component['gradientOverlay']) && $component['gradientOverlay'] === true ? 'xl:leading-tight' : 'text-black'}}">
                @if(!empty($item['excerpt']))<p class="my-1">{!! strip_tags($item['excerpt'], ['em', 'strong']) !!}</p>@endif 
                @if(!empty($item['description']))
                    @if (!empty($item['link']))
                        <div class="-mb-3">{!! preg_replace(array('"<a href(.*?)>"', '"</a>"'), array('',''), $item['description']) !!}</div>
                    @else
                        <div class="-mb-3">{!! $item['description'] !!}</div>
                    @endif
                @endif
            </div>
        </div>
    </div>
<{{ !empty($item['link']) ? '/a' : '/div' }}>
