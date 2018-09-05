{{--
    $button => array // [['title', 'link', 'excerpt', 'relative_url', 'secondary_image']]
--}}

<a href="{{ $button['link'] }}" class="block min-w-full relative rounded bg-grey-lighter bg-cover" style="padding-top: 36.39%; background-image: url('{{ $button['relative_url'] }}'); ">
    <div class="absolute pin p-4 rounded bg-grey-lighter opacity-65"></div>
    <div class="absolute min-w-full flex pin content-start items-center p-4">
        <div class="w-1/4">
        <!-- TODO: DELETE // Dealing with styleguide secondary image -->@if(!empty($promo_group_id)) <img src="/promos/{{ $button['promo_group_id'] }}/{{ $button['secondary_image']}}"> @else <img src="{{ $button['secondary_image']}}"> @endif
        </div>
        <div class="w-3/4 pl-4">
            <div class="block text-xl font-bold text-black leading-tight">{{ $button['title'] }}</div>
            @if(!empty($button['excerpt']))
                <div class="block text-black leading-tight">{{ $button['excerpt'] }}</div>
            @endif
        </div>
    </div>
</a>
