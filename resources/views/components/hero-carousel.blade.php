@if(!empty($hero['data']))
    <section id="hero"
         class="GTM-hero hero--carousel
              {{ $hero['component']['containerClass'] ?? ' hero'}}
              {{ config('base.global.sites.'.$base['site']['id'].'.promos.hero.class') ?? ''}}
              {{ !empty($hero['data']) && count($hero['data']) > 1 ? ' rotate' : '' }}
    ">
        @foreach($hero['data'] as $item)
            @if(count($hero['data']) > 1)<div class="hero__carousel-item">@endif

                <div @class(['hero__type', implode(' ', $item['hero_classes'] ?? ['hero--banner'])])>

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
