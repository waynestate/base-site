(function () {
    "use strict";

    const VIDEO_ID = 'js-video-hero';
    const PLAY_PAUSE_BTN_ID = 'js-play-pause-btn';
    const VIDEO_STATE_ID = 'js-video-state';
    const VIDEO_STATUS_ID = 'js-video-status';
    const PLAY_ICON_ID = 'js-play-icon';
    const PAUSE_ICON_ID = 'js-pause-icon';

    const MOBILE_BREAKPOINT = 755;
    const VIEW_COUNT_THRESHOLD = 30;
    const MINIMUM_PLAY_DURATION = 15; // seconds
    const INTERACTION_DELAY = 100; // ms debounce for interaction events

    let videoHero = document.getElementById(VIDEO_ID);
    let playPauseBtn = document.getElementById(PLAY_PAUSE_BTN_ID);
    let videoState = document.getElementById(VIDEO_STATE_ID);
    let videoStatus = document.getElementById(VIDEO_STATUS_ID);
    let playIcon = document.getElementById(PLAY_ICON_ID);
    let pauseIcon = document.getElementById(PAUSE_ICON_ID);

    // Exit if required elements are not present
    if (!videoHero || !playPauseBtn || !videoState || !videoStatus || !playIcon || !pauseIcon) {
        return;
    }

    const videoVersion = videoHero.getAttribute('data-version') || 'anonymous';
    const videoDescription = playPauseBtn.getAttribute('data-description') || 'Playing video';
    const STORAGE_KEY = `hero_video_views_${videoVersion}`;

    let playStartTime = null;
    let hasUserInteracted = false;
    let interactionTimeout = null;
    let hasAutoPlayed = false;

    /**
     * Detects if the user is on a mobile device
     * (screen width and touch capability)
     */
    function isMobile() {
        const hasTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
        const isNarrowScreen = window.innerWidth < MOBILE_BREAKPOINT;
        return hasTouch && isNarrowScreen;
    }

    /**
     * Checks if user has prefers-reduced-motion enabled
     */
    function prefersReducedMotion() {
        return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    /**
     * Gets the current view count from localStorage
     */
    function getViewCount() {
        try {
            const count = localStorage.getItem(STORAGE_KEY);
            return count ? parseInt(count, 10) : 0;
        } catch {
            return 0;
        }
    }

    /**
     * Increments the view count in localStorage
     */
    function incrementViewCount() {
        try {
            const currentCount = getViewCount();
            const newCount = currentCount + 1;
            localStorage.setItem(STORAGE_KEY, String(newCount));
        } catch {
            // Silent if localStorage is not available
        }
    }

    /**
     * Checks if the video should autoplay based on view count
     */
    function shouldAutoPlay() {
        return getViewCount() < VIEW_COUNT_THRESHOLD;
    }

    /**
     * Updates the play/pause button icons and aria labels
     */
    function updateButtonState(isPlaying) {
        if (isPlaying) {
            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
            videoStatus.textContent = 'Pause background video';
            playPauseBtn.setAttribute('aria-label', 'Pause background video');
        } else {
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
            videoStatus.textContent = 'Play background video';
            playPauseBtn.setAttribute('aria-label', 'Play background video');
        }
    }

    /**
     * Announces state changes to screen readers
     */
    function announceStateChange(message) {
        videoState.textContent = message;
    }

    /**
     * Starts video playback
     */
    function playVideo() {
        videoHero.play().catch(() => {
            // Autoplay was prevented (edge case)
        });

        if (!playStartTime) {
            playStartTime = Date.now();
        }

        updateButtonState(true);
        announceStateChange(videoDescription);
    }

    /**
     * Pauses video playback
     * If user manually pauses, track the watch time
     */
    function pauseVideo(isManualPause = false) {
        videoHero.pause();

        // Track view if video was playing long enough
        if (isManualPause && playStartTime) {
            const playDuration = (Date.now() - playStartTime) / 1000;
            if (playDuration >= MINIMUM_PLAY_DURATION && shouldAutoPlay()) {
                incrementViewCount();
            }
            playStartTime = null;
        }

        updateButtonState(false);
        announceStateChange('Video now paused');
    }

    /**
     * Handles play/pause button clicks
     */
    function handleButtonClick() {
        if (videoHero.paused) {
            playVideo();
        } else {
            pauseVideo(true);
        }
    }

    /**
     * Handles user interaction (mouse movement or scroll) on desktop
     */
    function handleUserInteraction() {
        if (hasUserInteracted || !shouldAutoPlay() || isMobile() || prefersReducedMotion() || hasAutoPlayed) {
            return;
        }

        // Debounce interactions
        if (interactionTimeout) {
            return;
        }

        interactionTimeout = setTimeout(() => {
            hasUserInteracted = true;
            hasAutoPlayed = true;
            playVideo();

            // Clean up interaction listeners after autoplay
            removeInteractionListeners();

            interactionTimeout = null;
        }, INTERACTION_DELAY);
    }

    /**
     * Removes interaction event listeners
     */
    function removeInteractionListeners() {
        document.removeEventListener('mousemove', handleUserInteraction);
        document.removeEventListener('scroll', handleUserInteraction);
    }

    /**
     * Tracks when video ends to count as a view
     */
    function handleVideoEnded() {
        if (playStartTime) {
            const playDuration = (Date.now() - playStartTime) / 1000;
            if (playDuration >= MINIMUM_PLAY_DURATION && shouldAutoPlay()) {
                incrementViewCount();
            }
            playStartTime = null;
        }
        updateButtonState(false);
    }

    /**
     * Tracks view count when page unloads or becomes hidden
     */
    function handlePageUnload() {
        if (playStartTime && !videoHero.paused) {
            const playDuration = (Date.now() - playStartTime) / 1000;
            if (playDuration >= MINIMUM_PLAY_DURATION && shouldAutoPlay()) {
                incrementViewCount();
                playStartTime = null;
            }
        }
    }

    /**
     * Tracks view count when page visibility changes (tab switch, etc.)
     */
    function handleVisibilityChange() {
        if (document.hidden && playStartTime && !videoHero.paused) {
            const playDuration = (Date.now() - playStartTime) / 1000;
            if (playDuration >= MINIMUM_PLAY_DURATION && shouldAutoPlay()) {
                incrementViewCount();
                playStartTime = null;
            }
        }
    }

    /**
     * Initializes the video hero
     */
    function init() {
        // Show the video and button
        videoHero.classList.remove('hidden');
        playPauseBtn.classList.remove('hidden');

        // Set initial button state (always show play initially)
        updateButtonState(false);

        // Add button click handler
        playPauseBtn.addEventListener('click', handleButtonClick);

        // Add video ended event listener
        videoHero.addEventListener('ended', handleVideoEnded);

        // Track page unload and visibility changes
        window.addEventListener('beforeunload', handlePageUnload);
        window.addEventListener('pagehide', handlePageUnload);
        document.addEventListener('visibilitychange', handleVisibilityChange);

        // On mobile, video only plays on manual button click
        if (isMobile()) {
            return;
        }

        // If user prefers reduced motion, don't autoplay
        if (prefersReducedMotion()) {
            return;
        }

        // If user has seen video up to threshold, don't autoplay
        if (!shouldAutoPlay()) {
            return;
        }

        // On desktop, set up interaction listeners for autoplay
        document.addEventListener('mousemove', handleUserInteraction);
        document.addEventListener('scroll', handleUserInteraction, { passive: true });
    }

    init();
})();
