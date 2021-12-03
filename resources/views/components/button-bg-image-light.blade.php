{{--
    $button => array // ['title', 'link', 'relative_url']
--}}

@if(!empty($button['link']) && !empty($button['relative_url']))
    <a href="{{ $button['link'] }}" class="block relative rounded bg-white overflow-hidden {{ $class ?? '' }}">
        <img src="{{ $button['relative_url'] }}" alt="{{ $button['filename_alt_text'] }}">
        <div class="absolute inset-0 bg-white opacity-75"></div>
        <div class="absolute inset-0 p-4 flex items-center">
            <div class="w-full text-lg xl:text-xl font-bold text-black leading-tight text-center">{{ $button['title'] }}</div>
        </div>
    </a>
@endif

