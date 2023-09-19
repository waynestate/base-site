<div class="col-span-1">
    @if(!empty($data[0]['component']['heading']))<h2 class="mt-0">{{ $data[0]['component']['heading'] }}</h2>@endif
    <div class="w-full">
        <a class="play-video-button" href="{{ $data['link'] }}">
            @if(!empty($data['relative_url']))
                @image($data['relative_url'], $data['filename_alt_text'], "lazy")
            @else
                @image('//i.wayne.edu/youtube/'.$data['youtube_id'].'/max', $data['filename_alt_text'], "lazy")
            @endif
        </a>
        <div class="text-xl font-bold mt-2 mb-1">{{ $data['title'] }}</div>
        @if(!empty($data['excerpt']))<div class="mb-1">{{ $data['excerpt'] }}</div>@endif
        @if(!empty($data['description']))<div class="content">{!! $data['description'] !!}</div>
        @endif
    </div>
</div>
