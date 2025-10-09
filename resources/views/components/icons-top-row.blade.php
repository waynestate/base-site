{{--
    $item => array // ['title', 'link', 'excerpt', 'relative_url', 'filename_alt_text']
--}}
<ul class="grid items-start gap-6 gap-y-2 lg:gap-8 lg:gap-y-4 grid-cols-2 lg:grid-cols-{{ !empty($component['columns']) && count($data) % 2 == 0 ? '2' : '3' }} xl:grid-cols-{{ !empty($component['columns']) ? $component['columns'] : '2' }}">
    @foreach($data as $item)
        <li>
            @if (!empty($item['link']))
                <a href="{{ $item['link'] }}" class="text-center group">
            @else
                <div class="text-center">
            @endif
                @image($item['relative_url'], $item['filename_alt_text'], 'block mx-auto grow-0 shrink-0 mb-2 w-16'.(!empty($component['columns']) && $component['columns'] >= 5 ? ' xl:w-16' : ' xl:w-20'))
                <div>
                    <div class="font-bold text-xl mt-0 mb-1 no-underline group-hover:underline">{{ $item['title'] }}</div>
                    @if(!empty($item['excerpt']))<div class="text-sm text-black">{{ $item['excerpt'] }}</div>@endif
                    @if(!empty($item['description']))
                        @if (!empty($item['link']))
                            <div class="text-sm text-black content">{!! preg_replace(['"<a href(.*?)>"', '"</a>"'], '', $item['description']) !!}</div>
                        @else
                            <div class="text-sm text-black content">{!! $item['description'] !!}</div>
                        @endif
                    @endif
                </div>
            @if (!empty($item['link']))
                </a>
            @else
                </div>
            @endif
        </li>
    @endforeach
</ul>
