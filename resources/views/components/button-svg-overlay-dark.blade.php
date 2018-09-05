{{--
    $button => array // [['title', 'link', 'excerpt', 'relative_url', 'secondary_image']]
--}}

<a href="{{ $button['link'] }}" class="block min-w-full relative rounded bg-cover bg-green-darkest" style="padding-top: 36.39%; background-image: url('{{ $button['relative_url'] }}'); ">
    <div class="absolute pin p-4 rounded bg-green-darkest opacity-65"></div>
    <div class="absolute min-w-full pin rounded">
        <!-- TODO: DELETE // Dealing with styleguide secondary image -->@if(!empty($promo_group_id)) <img src="/promos/{{ $button['promo_group_id'] }}/{{ $button['secondary_image']}}"> @else <img src="{{ $button['secondary_image']}}"> @endif
    </div>
</a>
