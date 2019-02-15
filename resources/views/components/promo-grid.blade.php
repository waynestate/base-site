{{--
    $items => array // [['title', 'description']]
--}}
<div class="flex flex-wrap -mx-4">
    @foreach($promo_grid as $item)
        <div class="w-full md:w-1/2 xl:w-1/3 px-4 pb-6">
            <a href="{{ $item['link'] }}" class="flex md:block">
                <div class="w-1/3 md:w-full">
                    <img src="{{ $item['relative_url'] }}" alt="" role="presentation" />
                </div>
                <div class="w-2/3 pl-4 md:pl-0">
                    <div class="font-bold hover:underline">{{ $item['title'] }}</div>
                    <p class="text-sm">{!! strip_tags($item['description']) !!}</p>
                </div>
            </a>
        </div>
    @endforeach
</div>
