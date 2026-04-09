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
            <div @class(['hero__type', implode(' ', $item['hero_classes'] ?? ['hero--banner'])])>
                <img class="hero__primary-image {{ $hero['component']['backgroundClass'] ?? ''}}" src="{{ $item['relative_url'] }}" alt="{{ $item['filename_alt_text'] }}">

                @if(!empty($item['title']) || !empty($item['secondary_relative_url']))
                    <div class="hero__content">
                        @if(!empty($item['secondary_relative_url']))
                            @if(empty($item['title']) && !empty($item['link']))<a href="{{ $item['link'] }}"><span class="absolute inset-0 z-10"></span>@endif
                                <img class="hero__secondary-image" src="{{ $item['secondary_relative_url'] }}" alt="{{ $item['secondary_alt_text'] }}">
                            @if(empty($item['title']) && !empty($item['link']))</a>@endif
                        @endif

                        @if(!empty($item['title']))
                            <div class="hero__title">
                                @if(!empty($item['link']))<a href="{{ $item['link'] }}"><span class="absolute inset-0 z-10"></span>@endif
                                    {!! strip_tags($item['title'], ['em']) !!}
                                @if(!empty($item['link']))</a>@endif
                            </div>
                        @endif

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
                @endif
            </div>

        @endforeach
    </section>
@endif
