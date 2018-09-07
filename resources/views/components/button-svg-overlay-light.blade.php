{{--
    $button => array // [['title', 'link', 'excerpt', 'relative_url', 'secondary_relative_url']]
--}}

@if(!empty($button['link']) && !empty($button['relative_url']) && !empty($button['secondary_relative_url']))
    <a href="{{ $button['link'] }}" class="block min-w-full relative rounded bg-cover bg-grey-lighter" style="padding-top: 36.39%; background-image: url('{{ $button['relative_url'] }}'); ">
        <div class="absolute pin p-4 rounded bg-white opacity-65"></div>
        <div class="absolute min-w-full pin rounded">
            <img src="{{ $button['secondary_relative_url']}}">
        </div>
    </a>
@endif
