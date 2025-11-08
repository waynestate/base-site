@if(!empty($hero['data']))
    <section id="hero" 
         class="GTM-hero
              {{ $hero['component']['containerClass'] ?? ' hero'}}
              {{ config('base.global.sites.'.$base['site']['id'].'.promos.hero.class') ?? ''}}
              {{ !empty($hero['data']) && count($hero['data']) > 1 ? ' rotate' : '' }}
    ">

        @foreach($hero['data'] as $item)
            @if(count($hero['data']) > 1)<div class="hero__carousel-item">@endif

                <div class="hero__type hero--{{ $item['hero_type'] ?? 'banner' }}">

                    <img class="hero__primary-image {{ $hero['component']['backgroundClass'] ?? ''}}{{ $loop->first ? '' : ' lazy'}}" 
                         @if($loop->first) src="{{ $item['relative_url'] }}" @else data-src="{{ $item['relative_url'] }}"@endif 
                        alt="{{ $item['filename_alt_text'] }}">

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
                            <div class="hero__description">
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
            @if(count($hero['data']) > 1)</div>@endif
        @endforeach
    </section>
@endif

{{--
    $base['hero']['component']['heroSize'] => string // ['large', 'small', 'contained']
    $hero['component']['heroSize'] => array // ['large','small','contained']
    $hero['component']['heroStyle'] => array // ['banner', 'text overlay', 'svg overlay', 'logo overlay', 'half', 'video']
    $hero['component']['option'] => array // ['large', 'small', 'contained', 'text overlay', 'svg overlay', 'half', 'video']
    $hero['data'] => array // ['relative_url', 'title', 'description']
    $heroClass => string, 'class-name'

    Enable to carousel by increasing the limit of hero items.
    Add specific classes in base config under global -> sites -> promos -> hero -> class = 'class-name'
    Add your specific css in scss/subsite/_main.scss
    Hero buttons are in text-overlay
--}}
