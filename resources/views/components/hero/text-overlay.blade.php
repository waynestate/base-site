<div class="hero__wrapper w-full relative">
    <div class="hero__primary-image pt-hero w-full bg-cover bg-top relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $image['relative_url'] }}')" @else data-src="{{ $image['relative_url'] }}"@endif></div>
    <div class="hero__content-position relative md:absolute print:relative md:bottom-0 md:inset-x-0 md:text-white md:white-links content md:bg-gradient-darkest">
        <div class="row">
            <div class="hero__content mx-4 relative pb-0 pt-4 @if(in_array($base['page']['controller'], config('base.hero_full_controllers'))) md:pb-2 md:pt-8 md:pt-20 @else md:pt-12 @endif">
                <div class="hero__title md:text-shadow-darkest leading-tight text-2xl mb-1 @if(in_array($base['page']['controller'], config('base.hero_full_controllers')))xl:text-5xl @else xl:text-3xl @endif">{{ $image['title'] }}</div>
                @if(!empty($image['description']))<div class="hero__description md:text-lg">{!! $image['description'] !!}</div>@endif
            </div>
        </div>
    </div>
</div>
