{{--
    $item => single // ['title', 'excerpt', 'description', 'link', 'filename_url', 'filename_alt_text']
--}}
@foreach($data as $item)
    <{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="md:flex items-start gap-x-3 lg:gap-x-6 mb-8 {{ !empty($item['link']) ? 'group' : '' }}">
        @if(!empty($item['youtube_id']))
            <div class="play-video-button md:w-2/5 shrink-0 grow-0 @if($loop->even) md:order-2 @endif">
                @if(!empty($item['filename_url']))
                    @image($item['filename_url'], $item['filename_alt_text'], "w-full lazy")
                @else
                    @image('//i.wayne.edu/youtube/'.$item['youtube_id'].'/max', $item['filename_alt_text'], "w-full lazy")
                @endif
            </div>
        @elseif(!empty($item['filename_url']))
            @image($item['filename_url'], $item['filename_alt_text'], "lazy w-full md:w-2/5 shrink-0 grow-0".($loop->even === true ? ' md:order-2' : ''))
        @endif

        <div class="md:mt-0 content">
            <div class="font-bold text-xl lg:text-2xl mt-1 group-hover:underline group-focus:underline">{{ $item['title'] }}</div>
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
@endforeach
