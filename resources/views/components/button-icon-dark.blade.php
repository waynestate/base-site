{{--
    $button => array // [['title', 'link', 'excerpt', 'seconardy_relative_url']]
--}}

@if(!empty($button['link']) && !empty($button['secondary_relative_url']))
    <a href="{{ $button['link'] }}" class="block min-w-full relative rounded bg-gradient-green hover:bg-gradient-green">
        <div class="min-w-full flex p-3 xl:p-4 @if(!empty($button['excerpt'])) items-top @else items-center @endif">
            <div class="w-1/6">
                <img src="{{ $button['secondary_relative_url']}}" class="block" alt="">
            </div>
            <div class="w-5/6 pl-2 xl:pl-4">
                <div class="block text-md xl:text-xl font-bold text-white leading-tight">{{ $button['title'] }}</div>
                @if(!empty($button['excerpt']))
                    <div class="leading-tight text-sm text-white pb-1">{{ $button['excerpt'] }}</div>
                @endif
            </div>
        </div>
    </a>
@endif
