{{--
    $button => array // ['title', 'link', 'relative_url']
--}}

@if(!empty($button['link']) && !empty($button['relative_url']))
    <a href="{{ $button['link'] }}" class="content-button block min-w-full relative rounded bg-cover bg-green-darkest overflow-hidden my-2" style="padding-top: 36.39%; background-image: url('{{ $button['relative_url'] }}'); ">
        <div class="absolute inset-0 p-4 rounded bg-green-darkest opacity-65"></div>
        <div class="absolute inset-0 p-4 flex items-center">
            <div class="min-w-full text-lg xl:text-xl font-bold text-white leading-tight text-center">{{ $button['title'] }}</div>
        </div>
    </a>
@endif
