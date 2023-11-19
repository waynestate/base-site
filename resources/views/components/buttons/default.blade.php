{{--
    $button => array // ['title', 'link', 'excerpt', 'relative_url']
--}}

@if(!empty($button['link']))
    <a href="{{ $button['link'] }}" class="button {{ $class }}  @if(!empty($button['excerpt'])) button--two-line @elseif(!empty($button['relative_url'])) button--icon-one-line @endif ">
        @if(!empty($button['relative_url'])) @image($button['relative_url'], $button['filename_alt_text'], 'button__image lazy') @endif

        <div class="button__title">{{ $button['title'] }}</div>
        @if(!empty($button['excerpt']))<div class="button__excerpt">{{ $button['excerpt'] }}</div>@endif
    </a>
@endif
