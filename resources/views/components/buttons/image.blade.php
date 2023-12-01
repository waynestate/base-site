{{--
    $button => array // ['title', 'link', 'relative_url', 'secondary_relative_url']
--}}

@if(!empty($button['link']) && !empty($button['relative_url']))
    <a href="{{ $button['link'] }}" class="block relative rounded overflow-hidden mb-2 {{ $class ?? '' }}">
        @image($button['relative_url'], $button['filename_alt_text'])
        @if(!empty($button['secondary_relative_url']))
            <div class="absolute inset-0">@image($button['secondary_relative_url'], $button['secondary_alt_text'], 'w-full')</div>
        @endif
    </a>
@endif
