{{--
    $button => array // [['title', 'link', 'excerpt', 'relative_url']]
--}}

<a href="{{ $button['link'] }}" class="block min-w-full relative rounded bg-grey-lighter bg-cover" style="padding-top: 36.39%; background-image: url('{{ $button['relative_url'] }}');">
    <div class="absolute pin p-4 rounded bg-white opacity-65"></div>
    <div class="absolute pin p-4 flex @if(!empty($button['excerpt'])) justify-start flex-col @else items-center @endif">
        <div class="min-w-full text-lg xl:text-xl font-bold text-black leading-tight @if(empty($button['excerpt'])) text-center @endif">{{ $button['title'] }}</div>
        @if(!empty($button['excerpt']))
            <div class="min-w-full text-xs xl:text-sm text-black leading-tight">{{ $button['excerpt'] }}</div>
        @endif
    </div>
</a>
