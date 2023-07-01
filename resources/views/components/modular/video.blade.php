<blockquote class="col-span-2 lg:flex border-gold border-l-12 py-4 lg:pl-8 mx-4 lg:mr-4 gap-6 my-6">
    <div>
        <h2 class="mt-0 text-2xl">{{ $data['title'] }}</h2>
        <div class="content">{!! $data['description'] !!}</div>
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
</blockquote>
