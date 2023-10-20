{{--
    $image_promo => single // ['title', 'link', 'filename_url', 'filename_alt_text']
--}}

<div class="col-span-2 md:col-span-1">
    @if(!empty($data[0]['component']['heading']))<h2 class="mt-0">{{ $data[0]['component']['heading'] }}</h2>@endif
    <div class="grid gap-4">
        @foreach($data as $image_promo)
            <div class="bg-green-800">
                <a href="{{ $image_promo['link'] }}" class="relative block group">
                    @image($image_promo['filename_url'], $image_promo['filename_alt_text'], 'w-full')
                    <div class="bg-gradient-darkest absolute inset-x-0 bottom-0">
                        <div class="w-full text-white font-bold relative text-xl p-4 pb-3 pt-14 group-hover:underline group-focus:underline">
                            {{ $image_promo['title'] }}
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
