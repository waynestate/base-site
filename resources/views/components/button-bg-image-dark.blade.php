{{--
    $button => array // ['title', 'link', 'relative_url']
--}}

@if(!empty($button['link']) && !empty($button['relative_url']))
    <a href="{{ $button['link'] }}" class="group block relative rounded bg-green-900 overflow-hidden {{ $class ?? '' }}">
        @if(!empty($button['relative_url'])) @image($button['relative_url'], $button['filename_alt_text']) @endif
        <div class="absolute inset-0 bg-green-900 opacity-75 group-hover:opacity-90 transition-all"></div>
        <div class="absolute inset-0 flex items-center">
            @if(!empty($button['secondary_relative_url']))
                @image($button['secondary_relative_url'], $button['secondary_alt_text'])
            @else
                <div class="w-full text-lg xl:text-xl font-bold text-white leading-tight text-center px-4">{{ $button['title'] }}</div>
            @endif
        </div>
    </a>
@endif
