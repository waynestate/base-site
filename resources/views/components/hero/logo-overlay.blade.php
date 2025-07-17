{{--
    $item => array // ['relative_url', 'title', 'description', 'link', 'secondary_relative_url']
--}}

<div class="hero__wrapper hero--logo-overlay">
    <div class="hero__bg {{ $loop->first ? '' : 'lazy'}}" @if($loop->first === true) style="background-image: url('{{ $item['relative_url'] }}')" @else data-src="{{ $item['relative_url'] }}"@endif></div>
    <div class="hero__content">
        @if(!empty($item['secondary_relative_url']))
            <img class="hero__secondary-image" src="{{ $item['secondary_relative_url'] }}" alt="{{ $item['secondary_alt_text'] }}">
        @endif
        <div class="hero__title">
            {{ $item['title'] }}
        </div>
        @if(!empty($item['description']))<div class="hero__description">{!! $item['description'] !!}</div>@endif
    </div>
</div>
