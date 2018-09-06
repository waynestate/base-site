{{--
    $button => array // [['title', 'link', 'excerpt', 'relative_url', 'secondary_relative_url']]
--}}

<a href="{{ $button['link'] }}" class="block min-w-full relative rounded bg-gradient-green bg-cover" style="background-image: url('{{ $button['relative_url'] }}'); ">
    <div class="absolute pin rounded bg-green-darkest opacity-65"></div>
    <div class="min-w-full flex p-3 xl:p-4 relative @if(!empty($button['excerpt'])) items-top @else items-center @endif">
        <div class="w-1/6">
            <img src="{{ $button['secondary_relative_url']}}" class="block" aria-hidden="true" alt="" role="presentation">
        </div>
        <div class="w-5/6 pl-2 xl:pl-4">
            <div class="block text-md xl:text-xl font-bold text-white leading-tight">{{ $button['title'] }}</div>
            @if(!empty($button['excerpt']))
                <div class="leading-tight text-sm text-white pb-1">{{ $button['excerpt'] }}</div>
            @endif
        </div>
    </div>
</a>
