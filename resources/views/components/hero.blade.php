{{--
    $images => array // ['relative_url', 'title', 'description']

    Add specific classes in base config under global -> sites -> promos -> hero -> class = 'class-name'
    Add your specific css in scss/subsite/_main.scss
--}}
@if(!empty($data))
    <div role="complementary" class="GTM-hero 
        {{ $heroClass ?? '' }}
        {{ config('base.global.sites.'.$base['site']['id'].'.promos.hero.class') ?? ''}}
        {{ !empty($data) && count($data) > 1 ? ' rotate' : '' }}
    ">
        @foreach($data as $hero)
            @if(!empty($hero['relative_url']))
                @if(!empty($hero['option']))
                    @include('components/hero/'.Str::slug($hero['option']))
                @else
                    @if(!empty($base['layout']) && $base['layout'] === 'contained-hero') 
                        @include('components/hero/banner-large')
                    @else
                        @if(config('base.layout') === 'contained-hero')
                            @include('components/hero/banner-large')
                        @else
                            @include('components/hero/banner-small')
                        @endif
                    @endif
                @endif
            @endif
        @endforeach
    </div>
@endif
