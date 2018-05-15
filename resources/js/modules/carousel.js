var Flickity = require('flickity');

(function() {
    "use strict";

    /**
     * Carousel module.
     */
    class Carousel {

        constructor() {
            this._init();
        }

        /**
         * Initialize
         */
        _init() {
            new Flickity('.rotate', {
                on: {
                    ready: function() {
                        // Get the height of the first image that loaded and dynamically set the height
                        document.querySelector('.flickity-viewport').style.height = document.querySelector('.flickity-enabled .is-selected img').offsetHeight + 'px';
                    }
                },
                accessibility: true,
                prevNextButtons: true,
                pageDots: true,
                resize: true,
                setGallerySize: true,
                wrapAround: true,
            });
        }
    }

    // Initialize
    var carousel = new Carousel();

    // Register this module
    window.WayneState.register('carousel', carousel);
})();
