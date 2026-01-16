@if(!empty($hero['data']))
    <section id="hero" @class([
             'GTM-hero',
             'hero',
             config('base.global.sites.'.$base['site']['id'].'.promos.hero.class') ?? '',
             $hero['component']['containerClass'] ?? '',
             $class ?? '',
             'rotate' => (!empty($hero['data']) && count($hero['data']) > 1),
             ])>
        @foreach($hero['data'] as $item)
            <div @class(['hero__type', $item['hero_classes'] ?? ''])>
                <img class="hero__primary-image {{ $hero['component']['backgroundClass'] ?? ''}}" src="{{ $item['relative_url'] }}" alt="{{ $item['filename_alt_text'] }}">

                <div class="hero__content">
                    @if(!empty($item['secondary_relative_url']))
                        <img class="hero__secondary-image" src="{{ $item['secondary_relative_url'] }}" alt="{{ $item['secondary_alt_text'] }}">
                    @endif

                    <div class="hero__title">
                        @if(!empty($item['link']))<a href="{{ $item['link'] }}"><span class="absolute inset-0 z-10"></span>@endif
                            {!! strip_tags($item['title'], ['em']) !!}
                            @if(!empty($item['link']))</a>@endif
                    </div>

                    @if(!empty($item['description']))
                        <div class="hero__description content">
                            {!! $item['description'] !!}
                        </div>
                    @endif

                    @if(!empty($base['hero_buttons']))
                        <div class="hero__buttons">
                            @include('components/button-row', ['data' => $base['hero_buttons']['data'], 'component' => $base['hero_buttons']['component']])
                        </div>
                    @endif
                </div>
            </div>

        @endforeach
    </section>
@endif

{{--
    $base['hero']['component']['heroSize'] => string // ['large', 'small', 'contained']
    $hero['component']['heroSize'] => array // ['large','small','contained']
    $hero['component']['heroType'] => array // ['banner', 'text overlay', 'svg overlay', 'logo overlay', 'half', 'video']
    $hero['component']['option'] => array // ['large', 'small', 'contained', 'text overlay', 'svg overlay', 'half', 'video']
    $hero['data'] => array // ['relative_url', 'title', 'description']
    $heroClass => string, 'class-name'

    Enable to carousel by increasing the limit of hero items.
    Add specific classes in base config under global -> sites -> promos -> hero -> class = 'class-name'
    Add your specific css in scss/subsite/_main.scss
    Hero buttons are in text-overlay
--}}
