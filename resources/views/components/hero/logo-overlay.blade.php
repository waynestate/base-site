<div class="hero__wrapper w-full">
    <div class="relative overflow-hidden flex bg-green-900">
        <div class="hero__primary-image inset-0 absolute print:relative bg-cover bg-top opacity-20 {{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $hero['relative_url'] }}')" @else data-src="{{ $hero['relative_url'] }}"@endif></div>
        <div class="hero__content-position w-full relative text-white flex flex-col justify-center min-h-hero">
            <div class="hero__content row w-full px-4 pt-10 pb-6 text-center md:white-links content">
                @if(!empty($hero['secondary_relative_url']))<img class="hero__secondary-image mx-auto mb-4" src="{{ $hero['secondary_relative_url'] }}" alt="{{ $hero['secondary_alt_text'] }}">@endif
                <div class="hero__title md:drop-shadow-px leading-tight text-2xl mb-1 @if(in_array($base['page']['controller'], config('base.hero_full_controllers')))xl:text-5xl @else xl:text-3xl @endif">
                    {{ $hero['title'] }}
                </div>
                @if(!empty($hero['description']))<div class="hero__description md:text-lg">{!! $hero['description'] !!}</div>@endif
            </div>
        </div>
    </div>
</div>
