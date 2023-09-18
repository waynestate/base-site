<div class="col-span-2">
    @if(!empty($data['group']['heading']))<h2>{{ $data['group']['heading'] }}</h2>@endif
    <div class="lg:flex border-gold border-l-4 py-4 lg:pl-8 mx-4 lg:mr-4 gap-6 my-6">
        <div>
            @if(!empty($data['group']['heading']))
                <h2 class="text-2xl">{{ $data['title'] }}</h2>
            @else
                <h3 class="text-2xl">{{ $data['title'] }}</h3>
            @endif
            @if(!empty($data['excerpt']))<div class="-mt-2 mb-2">{{ $data['excerpt'] }}</div>@endif
            @if(!empty($data['description']))<div class="content">{!! $data['description'] !!}</div>@endif
        </div>
        <div class="lg:w-1/3 xl:w-1/2 shrink-0 grow-0">
            <a class="play-video-button" href="{{ $data['link'] }}">
                @if(!empty($data['relative_url']))
                    @image($data['relative_url'], $data['filename_alt_text'], "lazy")
                @else
                    @image('//i.wayne.edu/youtube/'.$data['youtube_id'].'/max', $data['filename_alt_text'], "lazy")
                @endif
            </a>
        </div>
    </div>
</div>
