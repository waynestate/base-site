<div class="hero__wrapper hero-video mb-4 w-full min-h-hero relative overflow-hidden flex" aria-atomic="true" role="player">
    <div class="hero__primary-image inset-0 absolute print:relative bg-cover bg-top opacity-20" style="background-image: url('{{ $hero['relative_url'] }}')"></div>

    <div class="hero__content-position z-10 w-full relative flex flex-col justify-center">
        <div class="hero__content row w-full px-4 pt-10 pb-6 text-center md:white-links content">
            <div class="hero__title text-white text-2xl lg:text-4xl bold uppercase">{!! $hero['title'] !!}</div>
        </div>
    </div>

    @if(!empty($hero['secondary_relative_url']))
        <div class="hero__video-state" id="video_state" aria-live="assertive" aria-atomic="true"></div>

        <video class="hero__video absolute backdrop-opacity-10 top-0 left-0 object-cover w-full h-full hidden" autoplay muted loop id="videoHero" poster="{{ $hero['relative_url'] }}">
            <source data-src="{{ $hero['secondary_relative_url'] }}" src="{{ $hero['secondary_relative_url'] }}" type="video/mp4">
        </video>

        <button class="hero__video-button z-10 absolute right-3.5 bottom-3.5 hidden" id="playPauseBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45" role="img">
                <g class="fill-green-100 hover:fill-green-300 hidden" style="" id="play-icon">
                    <path d="M24 4C12.95 4 4 12.95 4 24s8.95 20 20 20 20-8.95 20-20S35.05 4 24 4zm-4 29V15l12 9-12 9z"></path>
                </g>

                <g class="fill-green-100 hover:fill-green-300" style="" id="pause-icon">
                    <path d="M24 4C12.95 4 4 12.95 4 24s8.95 20 20 20 20-8.95 20-20S35.05 4 24 4zm-2 28h-4V16h4v16zm8 0h-4V16h4v16z"></path>
                </g>
            </svg>

            <span class="hero__video-pause visually-hidden" id="video_status" aria-controls="video_state">Pause Background Video</span>
        </button>
    @endif

    <div class="hero__gradient absolute top-0 left-0 w-full h-full opacity-50 bg-gradient-gold-to-green"></div>
</div>
