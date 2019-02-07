{{--
    $video_full => array // [['title', 'link', 'relative_url']]
--}}

<a href="{{ $video_full['link'] }}">
    <div class="w-full relative">
        <div class="w-full bg-cover bg-black bg-gradient-dark overflow-hidden bg-center relative min-h-sm lg:min-h-md xxxl:min-h-lg lazy" data-src="{{ $video_full['relative_url'] }}"></div>
        <div class="absolute pin-x pin-y py-4 h-full">
            <div class="row flex flex-wrap items-end h-full">
                <span class="right-triangle opacity-75 text-white bg-transparent mx-auto rounded-full text-5xl lg:text-5rem leading-none border-4 lg:border-4 py-4 pr-4 pl-6 lg:pt-6 lg:pb-7 lg:pr-7 lg:pl-8 border-white transition transition-delay-none transition-timing-ease-in-out hover:opacity-75 hover:bg-grey-darkest"></span>
                <h2 class="leading-tight text-white text-lg md:text-xl lg:text-2xl mx-4 text-shadow-dark text-center w-full">{{ $video_full['title'] }}</h2>
            </div>
        </div>
    </div>
</a>
