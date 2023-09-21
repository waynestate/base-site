<div class="col-span-1">
    @if(!empty($data[0]['component']['heading']))<h2 class="mt-0">{{ $data[0]['component']['heading'] }}</h2>@endif
    @foreach($data as $item)
        <div class="w-full">
            <a class="play-video-button" href="{{ $item['link'] }}">
                @if(!empty($item['relative_url']))
                    @image($item['relative_url'], $item['filename_alt_text'], "lazy")
                @else
                    @image('//i.wayne.edu/youtube/'.$item['youtube_id'].'/max', $item['filename_alt_text'], "lazy")
                @endif
            </a>
            <div class="text-xl font-bold mt-2 mb-1">{{ $item['title'] }}</div>
            @if(!empty($item['excerpt']))<div class="mb-1">{{ $item['excerpt'] }}</div>@endif
            @if(!empty($item['description']))<div class="content">{!! $item['description'] !!}</div>
            @endif
        </div>
    @endforeach
</div>
