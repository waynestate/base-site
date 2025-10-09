{{--
    $item => array // ['relative_url', 'title', 'link', 'secondary_relative_url']
--}}

<div class="hero__wrapper hero--svg-overlay">
    @if(!empty($item['link']))<a class="hero__link" href="{{ $item['link'] }}">@endif
        <img class="hero__primary-image {{ $loop->first ? '' : 'lazy'}}" @if($loop->first) src="{{ $item['relative_url'] }}" @else data-src="{{ $item['relative_url'] }}"@endif alt="{{ $item['filename_alt_text'] }}">
        <img class="hero__secondary-image {{ $loop->first ? '' : 'lazy'}}" @if($loop->first) src="{{ $item['secondary_relative_url'] }}" @else data-src="{{ $item['secondary_relative_url'] }}"@endif alt="{{ $item['secondary_alt_text'] }}">
    @if(!empty($item['link']))</a>@endif
</div>
