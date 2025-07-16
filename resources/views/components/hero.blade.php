{{--
    $hero['component'] => array // ['option']
    $hero['data'] => array // ['relative_url', 'title', 'description']
    $heroClass => string, 'class-name'

    Enable to carousel by increasing the limit of hero items.
    Add specific classes in base config under global -> sites -> promos -> hero -> class = 'class-name'
    Add your specific css in scss/subsite/_main.scss
    Hero buttons are in text-overlay
--}}

@if(isset($hero['data']))
    <div role="complementary" class="hero GTM-hero {{ $heroClass ?? '' }} {{ config('base.global.sites.'.$base['site']['id'].'.promos.hero.class') ?? ''}} {{ !empty($hero['data']) && count($hero['data']) > 1 ? ' rotate' : '' }}">
        @foreach($hero['data'] as $item)
            <div class="hero__preserve-flickity">
                @if(isset($base['hero']['component']['option']))
                    @includeIf('components.hero.'.Str::slug($base['hero']['component']['option']), ['item' => $item, 'loop' => $loop ?? ''])
                @elseif(isset($item['option']))
                    @includeIf('components.hero.'.Str::slug($item['option']), ['item' => $item, 'loop' => $loop ?? ''])
                @else
                    @include('components.hero.banner-large'), ['item' => $item, 'loop' => $loop ?? ''])
                @endif
            </div>
        @endforeach
    </div>
@endif
