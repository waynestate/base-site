@if(isset($hero['data']))
    <div role="complementary" class="hero GTM-hero 
       {{ $heroClass ?? '' }} 
       {{-- move below into modular repo --}}
       {{ config('base.global.sites.'.$base['site']['id'].'.promos.hero.class') ?? ''}} 
       {{ !empty($hero['data']) && count($hero['data']) > 1 ? ' rotate' : '' }}
    ">

        @foreach($hero['data'] as $item)

            @if(count($hero['data']) > 1)<div class="hero__preserve-flickity">@endif
                <div class="hero__wrapper hero--{{ $base['hero']['component']['heroStyle'] ?? 'banner' }}">

                    <img class="hero__primary-image {{ $loop->first ? '' : 'lazy'}}" @if($loop->first) src="{{ $item['relative_url'] }}" @else data-src="{{ $item['relative_url'] }}"@endif alt="{{ $item['filename_alt_text'] }}">

                    <div class="hero__content-position">
                        <div class="hero__content">
                            {{-- logo overlay, svg overlay, video --}}
                            @if(!empty($item['secondary_relative_url']))
                                <img class="hero__secondary-image" src="{{ $item['secondary_relative_url'] }}" alt="{{ $item['secondary_alt_text'] }}">
                            @endif

                            <div class="hero__title">
                                @if(!empty($item['link']))<a href="{{ $item['link'] }}">@endif
                                    {!! strip_tags($item['title'], ['em']) !!}
                                @if(!empty($item['link']))</a>@endif
                            </div>

                            @if(!empty($item['description']))<div class="hero__description">{!! $item['description'] !!}</div>@endif
                        </div>

                        @if(!empty($base['hero_buttons']))
                            <div class="hero__buttons">
                                @include('components/button-row', ['data' => $base['hero_buttons']['data'], 'component' => $base['hero_buttons']['component']])
                            </div>
                        @endif

                    </div>
                @if(count($hero['data']) > 1)</div>@endif
            </div>
        @endforeach
    </div>
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
