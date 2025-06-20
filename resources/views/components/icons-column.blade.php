{{--
    $item => array // ['title', 'link', 'excerpt', 'relative_url', 'filename_alt_text']
--}}
<ul class="grid grid-cols-1 items-start gap-6 lg:gap-8 mt-2 mb-8 lg:my-8">
    @foreach($data as $item)
        <li>
            @if (!empty($item['link']))
                <a href="{{ $item['link'] }}" class="flex items-start gap-x-4 group">
            @else
                <div class="flex items-start gap-x-4">
            @endif
                @image($item['relative_url'], $item['filename_alt_text'], 'grow-0 shrink-0 w-16')
                <div>
                    <div class="font-bold text-xl mt-0 mb-1 text-green no-underline group-hover:underline">{{ $item['title'] }}</div>
                    @if(!empty($item['excerpt']))<div class="text-sm text-black">{{ $item['excerpt'] }}</div>@endif
                    @if(!empty($item['description']))
                        @if (!empty($item['link']))
                            <div class="text-sm text-black">{!! preg_replace(['"<a href(.*?)>"', '"</a>"'], '', $item['description']) !!}</div>
                        @else
                            <div class="text-sm text-black">{!! $item['description'] !!}</div>
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
