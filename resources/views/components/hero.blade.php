{{--
    $images => array // ['relative_url']
    $class => string // 'hero--childpage' if used on a childpage with left menu, and any additional classes
--}}

{{-- <div class="{{ (count($images) > 1)? 'rotate ' : '' }} hero{{ isset($class) ? ' ' . $class : '' }}">
    @foreach($images as $image)
        <div class="hero__slide">
            @if($image == reset($images))<div class="hero__image" style="background-image: url('{{ $image['relative_url'] }}')">@else <div class="hero__image lazy" data-src="{{ $image['relative_url'] }}">@endif
                @if(!empty($image['excerpt']) && config('app.hero_text_enabled') && in_array($page['controller'], config('app.hero_text_controllers')))
                    <div class="hero__excerpt">
                        <div class="row px-4">
                            {{ $image['excerpt'] }} @if(!empty($image['link'])) <a href="{{ $image['link'] }}" class="hero__view-more">{{ config('app.hero_text_more') }}</a>@endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div> --}}

{{-- <div class="{{ (count($images) > 1)? 'ro1tate ' : '' }}">
    @foreach($images as $image)
        @if($loop->first === true)
            <div style="background-image: url('{{ $image['relative_url'] }}')"></div>
        @else
            <div class="lazy" data-src="{{ $image['relative_url'] }}"></div>
        @endif
    @endforeach
</div> --}}

<div class="hero{{ !empty($images) && count($images) > 1 ? ' rotate' : '' }}{{ !empty($show_site_menu) && $show_site_menu === false ? ' full' : ' contained' }}">
    @foreach($images as $image)
        @if($loop->first === true)
            <div class="carousel-cell" style="background-image: url('{{ $image['relative_url'] }}')"></div>
        @else
            <div class="carousel-cell lazy" data-src="{{ $image['relative_url'] }}"></div>
        @endif
    @endforeach
</div>
