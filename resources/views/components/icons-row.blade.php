{{--
    $item => array // ['title', 'link', 'excerpt', 'filename_url', 'filename_alt_text']
--}}
<ul class="grid items-start gap-6 lg:gap-8 mt-2 mb-8 lg:my-8 md:grid-cols-2 lg:grid-cols-{{ !empty($component['columns']) && $component['columns'] >= 3 ? '3' : '2' }} xl:grid-cols-{{ !empty($component['columns']) ? $component['columns'] : '2' }}">
    @foreach($data as $item)
        <li>
            <{{ !empty($item['link']) ? 'a href='.$item['link'] : 'div' }} class="flex items-start gap-x-4 {{ !empty($item['link']) ? 'group' : '' }}">
                @image($item['relative_url'], $item['filename_alt_text'], 'grow-0 shrink-0 w-16 '.(!empty($component['columns']) && $component['columns'] >= 3 ? ' xl:w-16' : ' xl:w-20'))
                <div>
                    <div class="font-bold text-xl xl:text-2xl mt-0 mb-1 no-underline group-hover:underline">{{ $item['title'] }}</div>
                    @if(!empty($item['excerpt']))<div class="text-sm lg:text-base text-black">{{ $item['excerpt'] }}</div>@endif
                    @if(!empty($item['description']))
                        <div class="text-sm xl:text-base text-black content">{!! !empty($item['link']) ? preg_replace(array('"<a href(.*?)>"', '"</a>"'), array('',''), $item['description']) : $item['description'] !!}</div>
                    @endif
                </div>
            <{{ !empty($item['link']) ? '/a' : '/div' }}>
        </li>
    @endforeach
</ul>
