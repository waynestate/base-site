<div id="js-video-state" aria-live="assertive" aria-atomic="true"></div>

<video
    id="js-video-hero"
    data-version="{{ $item['promo_item_id'] ?? '' }}"
    poster="{{ $item['filename_alt_text'] ?? '' }}"
    class="hero__video hidden"
    muted
    loop>
    <source
        data-src="{{ $item['relative_url'] }}"
        src="{{ $item['relative_url'] }}"
        type="{{ pathinfo($item['relative_url'], PATHINFO_EXTENSION) === 'webm' ? 'video/webm' : 'video/mp4' }}">
</video>

<button id="js-play-pause-btn" class="hero__play-pause-button hero__video-controls hidden" data-description="{{ $item['excerpt'] ?? 'Background video now playing' }}">
    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45">
        <g id="js-play-icon" class="hero__play-icon hidden">
            <path d="M24 4C12.95 4 4 12.95 4 24s8.95 20 20 20 20-8.95 20-20S35.05 4 24 4zm-4 29V15l12 9-12 9z"></path>
        </g>
        <g id="js-pause-icon" class="hero__pause-icon">
            <path d="M24 4C12.95 4 4 12.95 4 24s8.95 20 20 20 20-8.95 20-20S35.05 4 24 4zm-2 28h-4V16h4v16zm8 0h-4V16h4v16z"></path>
        </g>
    </svg>

    <span id="js-video-status" aria-controls="js-video-state" class="visually-hidden">Pause background video</span>
</button>
