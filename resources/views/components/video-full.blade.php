{{--
    $video_full => array // [['title', 'link', 'relative_url']]
--}}

<a href="{{ $video_full['link'] }}">
    <div class="w-full video relative">
        <div class="w-full bg-cover bg-black bg-gradient-dark overflow-hidden bg-center relative min-h-sm lg:min-h-md xxxl:min-h-lg lazy" data-src="{{ $video_full['relative_url'] }}"></div>
        <div class="absolute pin-x pin-y py-4 h-full">
            <div class="row flex flex-wrap items-end h-full">
                <span class="right-triangle text-white rounded-xxl xxl:rounded-xxxl mx-auto text-4xl lg:text-5xl xxl:text-7xl leading-none py-3 pr-5 pl-6 lg:pt-4 lg:pb-5 lg:pr-7 lg:pl-8 xxl:pt-5 xxl:pb-6 xxl:pr-10 xxl:pl-11 transition transition-delay-none transition-timing-ease-in-out"></span>
                <h2 class="leading-tight text-white text-lg md:text-xl lg:text-2xl mx-4 text-shadow-dark text-center w-full">{{ $video_full['title'] }}</h2>
            </div>
        </div>
    </div>
</a>
