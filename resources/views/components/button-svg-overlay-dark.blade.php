{{--
    $button => array // [['title', 'link', 'relative_url', 'secondary_relative_url']]
--}}

@if(!empty($button['link']) && !empty($button['relative_url']) && !empty($button['secondary_relative_url']))
    <a href="{{ $button['link'] }}" class="block min-w-full relative rounded bg-cover bg-green-darkest" style="padding-top: 36.39%; background-image: url('{{ $button['relative_url'] }}'); ">
        <div class="absolute pin p-4 rounded bg-green-darkest opacity-65"></div>
        <div class="absolute min-w-full pin rounded">
            @image($button['secondary_relative_url'], $button['title'])
        </div>
    </a>
@endif
