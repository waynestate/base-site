{{--
    $images => array // ['relative_url', 'title', 'description']

    Add specific classes in base config under global -> sites -> promos -> hero -> class = 'class-name'
    Add your specific css in scss/subsite/_main.scss
--}}
@if(!empty($data))
    <div {!! (in_array($base['page']['controller'], config('base.hero_full_controllers'))) ? ' role="complementary"' : '' !!}
        class="GTM-hero mt:mx-0
        {{ !empty($class) ? $class : '' }}
        {{ !empty($data) && count($data) > 1 ? ' rotate' : '' }}
        {{!in_array($base['page']['controller'], config('base.hero_full_controllers'))  ? '  -mx-4' : '' }}
        {{!empty(config('base.global.sites.'.$base['site']['id'].'.promos.hero.class')) ? ' '.config('base.global.sites.'.$base['site']['id'].'.promos.hero.class') : ''}}
    ">
        @foreach($data as $hero)
            @if(!empty($hero['relative_url']))
                @if(!empty($hero['option']))
                    @include('components/hero/'.Str::slug($hero['option']))
                @else
                    @include('components/hero/default')
                @endif
            @endif
        @endforeach
    </div>
@endif
