{{--
    $image_promo => single // ['title', 'link', 'filename_url', 'filename_alt_text']
--}}
@foreach($data as $image)
    <div class="grid gap-4">
        <div class="bg-green-800">
            <a href="{{ $image['link'] }}" class="relative block group">
                @image($image['filename_url'], $image['filename_alt_text'], 'w-full')
                <div class="bg-gradient-darkest absolute inset-x-0 bottom-0">
                    <div class="w-full text-white font-bold relative text-xl p-4 pb-3 pt-14 group-hover:underline group-focus:underline">
                        {{ $image['title'] }}
                    </div>
                </div>
            </a>
        </div>
    </div>
@endforeach
