{{--
    $button => array // ['title', 'link', 'relative_url']
--}}

@if(!empty($button['link']) && !empty($button['relative_url']))
    <a href="{{ $button['link'] }}" class="group block relative rounded bg-white overflow-hidden mb-2 {{ $class ?? '' }} ">
        <img src="{{ $button['relative_url'] }}" alt="{{ $button['filename_alt_text'] }}">
        <div class="absolute inset-0 bg-white opacity-75 group-hover:opacity-90 transition-all"></div>
        <div class="absolute inset-0 flex items-center">
            @if(!empty($button['secondary_relative_url']))
                @image($button['secondary_relative_url'], $button['secondary_alt_text'])
            @else
                <div class="w-full text-lg xl:text-xl font-bold text-green-900 leading-tight text-center px-4">{{ $button['title'] }}</div>
            @endif
        </div>
    </a>
@endif

