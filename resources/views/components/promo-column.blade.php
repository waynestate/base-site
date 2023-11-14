{{--
    This component's image is full width on small views
    $image_promo => single // ['title', 'link', 'filename_url', 'filename_alt_text']
--}}
@foreach($data as $promo)
    @if($loop->first)
        <a class="block group" href="{{ $promo['link'] }}">
            @if(!empty($promo['youtube_id']))
                <div class="play-video-button relative w-full bg-green aspect-video">
                    @if(!empty($promo['relative_url']))
                        @image($promo['relative_url'], $promo['filename_alt_text'], "lazy object-cover h-full w-full")
                    @else
                        @image('//i.wayne.edu/youtube/'.$promo['youtube_id'].'/max', $promo['filename_alt_text'], "lazy object-cover h-full w-full")
                    @endif
                </div>
            @else
                @image($promo['relative_url'], $promo['filename_alt_text'], "lazy")
            @endif
            <div class="text-lg text-green font-bold mt-2 group-hover:underline group-focus:underline">{{ $promo['title'] }}</div>
            @if(!empty($promo['excerpt']))<p class="text-base text-black mb-0 mt-1">{{ $promo['excerpt'] }}</p>@endif
            @if(!empty($promo['description']))<div class="text-base text-black mt-1">{!! strip_tags($promo['description'], ['p', 'strong', 'em']) !!}</div>@endif
        </a>
    @endif
@endforeach
