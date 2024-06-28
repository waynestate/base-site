{{--
    This component's image is 1/4 width on small views
    $item => array // ['title', 'link', 'description', 'excerpt', 'relative_url', 'option']
--}}

<{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="block {{ !empty($component['gradientOverlay']) && $component['gradientOverlay'] === true ? 'bg-green-800 relative overflow-hidden' : '' }} {{ !empty($item['link']) ? 'group' : '' }} {{ $loop->last != true && !empty($component['filename']) && $component['filename'] != 'catalog' ? 'mt-6 mb-8' : '' }}">
    <div class="{{ !empty($component['gradientOverlay']) ? '' : 'mb-2' }}">
        @if(!empty($item['youtube_id']))
            <div class="play-video-button">
                @if(!empty($item['relative_url']))
                    @image($item['relative_url'], $item['filename_alt_text'], "lazy block w-full")
                @else
                    @image('//i.wayne.edu/youtube/'.$item['youtube_id'].'/max', $item['title'], "lazy block w-full")
                @endif
            </div>
        @elseif(!empty($item['relative_url']))
            @image($item['relative_url'], $item['filename_alt_text'], "lazy block w-full")
        @endif
    </div>

    <div class="w-full {{ !empty($component['gradientOverlay']) && $component['gradientOverlay'] === true ? 'bg-gradient-darkest absolute inset-x-0 bottom-0' : '' }}">
        <div class="content {{ !empty($component['gradientOverlay']) && $component['gradientOverlay'] === true ? 'white-links text-white relative p-4 pt-20 drop-shadow-px' : '' }}">
            @if(!empty($item['youtube_id']) || !empty($item['relative_url']))
                <div class="my-1 font-bold {{ !empty($component['columns']) ? ($component['columns'] < 4 ? 'text-lg' : 'text-base') : 'text-xl' }} group-hover:underline group-focus:underline leading-snug xl:leading-tight">
                    {{ $item['title'] }}
                </div>
            @else
                @include('partials/heading', ['heading' => $item['title'], 'headingLevel' => $component['headingLevel'] ?? 'h3', 'headingClass' => (!empty($component['columns']) ? ($component['columns'] < 3 ? 'text-2xl' : 'text-xl') : 'text-2xl').' group-hover:underline group-focus:underline leading-snug xl:leading-tight '.($component['headingClass'] ?? '')])
            @endif
            <div class="{{ !empty($component['columns']) ? ($component['columns'] < 4 ? ($component['columns'] < 3 ? 'text-base md:text-base' : 'text-base md:text-sm xl:text-base') : 'text-sm') : 'text-base' }} {{ !empty($component['gradientOverlay']) && $component['gradientOverlay'] === true ? 'xl:leading-tight' : 'text-black'}}">
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
    </div>
{!! !empty($item['link']) ? '</a>' : '</div>' !!}
