{{--
    $button => array // ['title', 'link', 'relative_url', 'secondary_relative_url']
--}}

@if(!empty($button['link']) && !empty($button['relative_url']) && !empty($button['secondary_relative_url']))
    <a href="{{ $button['link'] }}" class="block relative rounded overflow-hidden bg-green-900 {{ $class ?? '' }}">
        @if(!empty($button['relative_url'])) @image($button['relative_url'], $button['filename_alt_text']) @endif
        <div class="absolute inset-0 p-4 bg-green-900 opacity-75"></div>
        <div class="absolute inset-0">
            @image($button['secondary_relative_url'], $button['secondary_alt_text'])
        </div>
    </a>
@endif
