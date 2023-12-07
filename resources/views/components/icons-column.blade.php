{{--
    $item => array // ['title', 'link', 'excerpt', 'filename_url', 'filename_alt_text']
--}}
<ul class="grid grid-cols-1 items-start gap-6 lg:gap-8 mt-2 mb-8 lg:my-8">
    @foreach($data as $item)
        <li>
            <{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="flex items-start gap-x-4 {{ !empty($item['link']) ? 'group' : '' }}">
                @image($item['relative_url'], $item['filename_alt_text'], 'grow-0 shrink-0 w-16')
                <div>
                    <div class="font-bold text-xl mt-0 mb-1 text-green no-underline group-hover:underline">{{ $item['title'] }}</div>
                    @if(!empty($item['excerpt']))<div class="text-sm text-black">{{ $item['excerpt'] }}</div>@endif
                    @if(!empty($item['description']))
                        <div class="text-sm text-black">{!! !empty($item['link']) ? preg_replace(array('"<a href(.*?)>"', '"</a>"'), array('',''), $item['description']) : $item['description'] !!}</div>
                    @endif
                </div>
            <{{ !empty($item['link']) ? '/a' : '/div' }}>
        </li>
    @endforeach
</ul>
