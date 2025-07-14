{{--
    $hero => array // ['relative_url', 'title']
--}}
<div class="hero__wrapper hero--banner-small">
    <img class="hero__primary-image {{ $loop->first ? '' : 'lazy'}}" @if($loop->first) src="{{ $item['relative_url'] }}" @else data-src="{{ $item['relative_url'] }}"@endif alt="{{ $item['filename_alt_text'] }}">
</div>

