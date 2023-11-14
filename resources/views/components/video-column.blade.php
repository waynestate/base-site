{{--
    $item => single // ['title', 'excerpt', 'description', 'link', 'filename_url', 'filename_alt_text']
--}}
@foreach($data as $item)
    <div>
        <a class="w-full block play-video-button" href="{{ $item['link'] }}">
            @if(!empty($item['filename_url']))
                @image($item['filename_url'], $item['filename_alt_text'], "lazy")
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
