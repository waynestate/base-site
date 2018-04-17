{{--
    $images => array // ['relative_url']
    $class => string // 'hero--childpage' if used on a childpage with left menu, and any additional classes
--}}

<div class="{{ (count($images) > 1)? 'rotate_arrows ' : '' }}overlay-arrows hero{{ isset($class) ? ' ' . $class : '' }}">
    @foreach($images as $image)
        @if($image == reset($images))
            <div class="hero__slide">
                <div class="hero__image" style="background-image: url('{{ $image['relative_url'] }}')">
                    @if(!empty($image['excerpt']) && config('app.hero_text_enabled') && in_array($page['controller'], config('app.hero_text_controllers')))
                        <div class="hero__excerpt">
                            <div class="row">
                                <div class="small-12 columns">
                                    {{ $image['excerpt'] }} @if(!empty($image['link'])) <a href="{{ $image['link'] }}" class="hero__view-more">{{ config('app.hero_text_more') }}</a>@endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="hero__slide">
                <div class="hero__image lazy" data-src="{{ $image['relative_url'] }}">
                    @if(!empty($image['excerpt']) && config('app.hero_text_enabled') && in_array($page['controller'], config('app.hero_text_controllers')))
                        <div class="hero__excerpt">
                            <div class="row">
                                <div class="small-12 columns">
                                    {{ $image['excerpt'] }} @if(!empty($image['link'])) <a href="{{ $image['link'] }}" class="hero__view-more">{{ config('app.hero_text_more') }}</a>@endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>
