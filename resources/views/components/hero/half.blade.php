<div class="hero__wrapper w-full relative xl:flex items-center">
    <img class="hero__pimary-image w-full xl:w-1/2 3xl:w-[60%] block shrink-0" alt="{{ $hero['filename_alt_text'] }}" src="{{ $hero['relative_url'] }}">
    <div class="hero__content-position relative p-6 xl:px-12 2xl:px-16">
        <div class="hero__content border-l-[12px] border-gold border-solid pl-4 2xl:pl-8 py-4">
            <h2 class="hero__title text-green-700 xl:text-4xl mb-1 font-black">
                @if(!empty($hero['link']))<a href="{{ $hero['link'] }}" class="hero__link text-green-700 no-underline hover:underline focus:underline">@endif
                    {{ $hero['title'] }}
                @if(!empty($hero['link']))</a>@endif
            </h2>
            <div class="hero__description text-lg xl:text-xl text-green-700">
                @if(!empty($hero['description']))
                    {!! $hero['description'] !!}
                @endif
            </div>
        </div>
    </div>
</div>
