{{--
    $images => array // ['relative_url']
    $class => string // 'hero--childpage' if used on a childpage with left menu, and any additional classes
--}}

@if(isset($images) && is_array($images))
    <div class="rotate_arrows overlay-arrows hero{{ isset($class) ? ' ' . $class : '' }}">
        @foreach($images as $image)
            @if($image == reset($images))
                <div class="hero__slide">
                    <div class="hero__image" style="background-image: url('{{ $image['relative_url'] }}')"></div>
                </div>
            @else
                <div class="hero__slide">
                    <div class="hero__image b-lazy" data-src="{{ $image['relative_url'] }}"></div>
                </div>
            @endif
        @endforeach
    </div>
@endif
