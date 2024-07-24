{{--
    This component's image is full width on small views
    $item => array // ['title', 'link', 'description', 'excerpt', 'relative_url', 'option']
--}}

<{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="promo__item block {{ $component['promoItemClass'] ?? '' }} {{ !empty($component['imageSize']) && $component['imageSize'] === 'small' ? 'flex items-start' : 'md:flex xl:items-center' }} gap-x-3 lg:gap-x-6 {{ !empty($item['link']) ? 'group' : '' }} {{ $loop->iteration > 1 && !empty($component['filename']) && $component['filename'] != 'catalog' ? 'mt-6' : '' }}">
    @if(!empty($item['youtube_id']) || !empty($item['relative_url']))
        <div class="shrink-0 grow-0 {{ !empty($component['imageSize']) && $component['imageSize'] === 'small' ? 'w-1/4' : 'md:w-2/5' }}  
            @if(!empty($component['imagePosition']) && ($component['imagePosition'] === 'right' || ($component['imagePosition'] === 'alternate' && $loop->even))) md:order-2 @endif">
            @if(!empty($item['youtube_id']))
                <div class="promo__video play-video-button">
                    @if(!empty($item['relative_url']))
                        @image($item['relative_url'], $item['filename_alt_text'], "promo__image w-full lazy")
                    @else
                        @image('//i.wayne.edu/youtube/'.$item['youtube_id'].'/max', $item['title'], "promo__image w-full lazy")
                    @endif
                </div>
            @elseif(!empty($item['relative_url']))
                @image($item['relative_url'], $item['filename_alt_text'], "promo__image lazy w-full")
            @endif
        </div>
    @endif

    <div class="content w-full">
        @if(!empty($component['showTitle']) && $component['showTitle'] != false)
            @if(!empty($item['youtube_id']) || !empty($item['relative_url']))
                <div class="promo__title mb-1 font-bold group-hover:underline group-focus:underline leading-tight text-lg lg:text-xl {{ !empty($component['imageSize']) && $component['imageSize'] === 'small' ? '' : 'mt-2 lg:mt-0' }}">{{ $item['title'] }}</div>
            @elseif (!empty($component['heading']))
                <h3 class="promo__title mt-0 mb-3 group-hover:underline group-focus:underline leading-tight">{{ $item['title'] }}</h3>
            @else
                <h2 class="promo__title mt-0 group-hover:underline group-focus:underline leading-tight">{{ $item['title'] }}</h2>
            @endif
        @endif
        <div class="promo__content text-black">
            @if(!empty($item['excerpt']))<p class="promo__excerpt my-1">{!! strip_tags($item['excerpt'], ['em', 'strong']) !!}</p>@endif 
            @if(!empty($item['description']))
                <div class="promo__description">
                    @if (!empty($item['link']))
                        {!! preg_replace(array('"<a href(.*?)>"', '"</a>"'), array('',''), $item['description']) !!}
                    @else
                        {!! $item['description'] !!}
                    @endif
                </div>
            @endif
        </div>
    </div>
{!! !empty($item['link']) ? '</a>' : '</div>' !!}
