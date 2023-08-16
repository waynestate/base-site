{{--
    $button => array // ['title', 'link', 'relative_url']
--}}

@if(!empty($button['link']) && !empty($button['relative_url']))
    @if(!empty($button['link']))<a href="{{ $button['link'] }}" class="block rounded overflow-hidden {{ $class ?? '' }}">@endif
        @image($button['relative_url'], !empty($button['filename_alt_text']) ? $button['filename_alt_text'] : $button['title'])
    @if(!empty($button['link']))</a>@endif
@endif
