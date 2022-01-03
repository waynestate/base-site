{{--
    $button => array // ['title', 'link', 'excerpt']
--}}

@if(!empty($button['link']))
    <a href="{{ $button['link'] }}" class="green-gradient-button @if(!empty($button['excerpt']) || !empty($button['relative_url']) || !empty($button['secondary_relative_url']))button--two-line @endif {{ $class ?? '' }}">
        @if(!empty($button['relative_url']) || !empty($button['secondary_relative_url']))<img src="{{ $button['relative_url'] ?? $button['secondary_relative_url'] }}" alt="{{ $button['filename_alt_text'] ?? $button['secondary_alt_text'] }}">@endif
        <div>{{ $button['title'] }}</div>
        @if(!empty($button['excerpt']))<div>{{ $button['excerpt'] }}</div>@endif
    </a>
@endif
