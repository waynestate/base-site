{{--
    $item => array // ['title', 'link', 'excerpt', 'filename_url', 'filename_alt_text']
--}}
<ul class="grid grid-cols-1 gap-6">
@foreach($data as $step)
    <li>
        <a class="block group" href="{{ $step['link'] }}">
            <div class="flex gap-3">
                <div class="w-16 grow-0 shrink-0">
                    @image($step['filename_url'], $step['filename_alt_text'], 'block mx-auto')
                </div>
                <div>
                    <div class="text-lg lg:text-base xl:text-xl mt-0 mb-1 underline group-hover:no-underline">{{ $step['title'] }}</div>
                    <p class="text-base lg:text-sm xl:text-base text-black mb-0">{{ $step['excerpt'] }}</p>
                </div>
            </div>
        </a>
    </li>
@endforeach
</ul>
