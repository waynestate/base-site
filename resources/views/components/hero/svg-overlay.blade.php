<div class="hero__wrapper w-full relative overflow-hidden">
    @if(!empty($hero['link']))<a class="hero__link" href="{{  $hero['link'] }}">@endif
        <div class="hero__primary-image pt-hero w-full bg-cover bg-top {{ $loop->first !== true ? ' lazy' : '' }}" @if($loop->first === true) style="background-image: url('{{ $hero['relative_url'] }}')" @else data-src="{{ $hero['relative_url'] }}"@endif></div>
        <div class="hero__content-position absolute print:relative inset-0 flex items-center justify-center">
            <img class="hero__secondary-image w-full max-w-full max-h-full" src="{{ $hero['secondary_relative_url'] }}" alt="{{ $hero['secondary_alt_text'] }}">
        </div>
    @if(!empty($hero['link']))</a>@endif
</div>
