<div class="col-span-2">
    @if(!empty($data[0]['component']['heading']))<h2 class="mt-0">{{ $data[0]['component']['heading'] }}</h2>@endif
    <div class="lg:flex border-gold border-l-4 pt-4 pb-6 pl-4 lg:pl-8 md:mx-4 lg:mr-4 gap-6 my-6">
        @foreach($data as $item)
            <div>
                @if(!empty($item['group']['heading']))
                    <h2 class="mt-0 text-2xl">{{ $item['title'] }}</h2>
                @else
                    <h3 class="mt-0 text-2xl">{{ $item['title'] }}</h3>
                @endif
                @if(!empty($item['excerpt']))<div class="-mt-2 mb-2">{{ $item['excerpt'] }}</div>@endif
                @if(!empty($item['description']))<div class="content">{!! $item['description'] !!}</div>@endif
            </div>
            <div class="lg:w-1/3 xl:w-1/2 shrink-0 grow-0">
                <a class="play-video-button" href="{{ $item['link'] }}">
                    @if(!empty($item['relative_url']))
                        @image($item['relative_url'], $item['filename_alt_text'], "lazy")
                    @else
                        @image('//i.wayne.edu/youtube/'.$item['youtube_id'].'/max', $item['filename_alt_text'], "lazy")
                    @endif
                </a>
            </div>
        @endforeach
    </div>
</div>
