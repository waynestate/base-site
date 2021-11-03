{{--
    $button => array // ['title', 'link', 'relative_url', 'secondary_relative_url']
--}}

@if(!empty($button['link']) && !empty($button['relative_url']) && !empty($button['secondary_relative_url']))
    <a href="{{ $button['link'] }}" class="content-button block min-w-full relative rounded bg-cover bg-green-900 my-2" style="padding-top: 36.39%; background-image: url('{{ $button['relative_url'] }}'); ">
        <div class="absolute inset-0 p-4 rounded bg-green-900 opacity-65"></div>
        <div class="absolute min-w-full inset-0 rounded">
            @image($button['secondary_relative_url'], $button['secondary_alt_text'])
        </div>
    </a>
@endif
