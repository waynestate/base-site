{{--
    $item => single // ['title', 'excerpt', 'description', 'link', 'filename_url', 'filename_alt_text']
--}}
<div class="col-span-2">
    @if(!empty($component['heading']))<h2 class="mt-0">{{ $component['heading'] }}</h2>@endif
    @foreach($data as $item)
        <div class="lg:flex mb-8">
            <div>
                @if(!empty($item['group']['heading']))
                    <h2 class="mt-0 text-2xl">{{ $item['title'] }}</h2>
                @else
                    <h3 class="mt-0 text-2xl">{{ $item['title'] }}</h3>
                @endif
                @if(!empty($item['excerpt']))<div class="-mt-2 mb-2">{{ $item['excerpt'] }}</div>@endif
                @if(!empty($item['description']))<div class="content">{!! $item['description'] !!}</div>@endif
            </div>
            <div class="lg:w-1/3 xl:w-1/2 shrink-0 grow-0 lg:ml-4">
                <a class="play-video-button" href="{{ $item['link'] }}">
                    @if(!empty($item['filename_url']))
                        @image($item['filename_url'], $item['filename_alt_text'], "lazy")
                    @else
                        @image('//i.wayne.edu/youtube/'.$item['youtube_id'].'/max', $item['filename_alt_text'], "lazy")
                    @endif
                </a>
            </div>
        </div>
    @endforeach
</div>
