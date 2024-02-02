{{--
    $hero => array // ['relative_url', 'title', 'description']
--}}

<div class="hero__wrapper w-full relative">
    <div class="hero__primary-image h-hero max-h-hero w-full bg-cover bg-center relative{{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $hero['relative_url'] }}')" @else data-src="{{ $hero['relative_url'] }}"@endif></div>
    <div class="hero__content-position relative md:absolute print:relative md:bottom-0 md:inset-x-0 md:text-white md:white-links md:bg-gradient-darkest">
        <div class="row">
            <div class="hero__content relative p-4 pb-0 md:pb-2 md:pt-8 md:pt-20">
                <div class="hero__title md:drop-shadow-px leading-tight text-2xl mb-1 xl:text-5xl">{!! strip_tags($hero['title'], ['em', 'strong']) !!}</div>
                @if(!empty($hero['description']))<div class="hero__description md:text-lg content">{!! $hero['description'] !!}</div>@endif
                @yield('hero-buttons')
            </div>
        </div>
    </div>
</div>
