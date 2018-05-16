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
            if(document.querySelector('.rotate') !== null) {
                new Flickity('.rotate', {
                    on: {
                        ready: function() {
                            // Get the height of the first image that loaded and dynamically set the height
                            if(document.querySelector('.flickity-enabled .is-selected img') != null) {
                                document.querySelector('.flickity-viewport').style.height = document.querySelector('.flickity-enabled .is-selected img').offsetHeight + 'px';
                            }
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
    }

    // Initialize
    var carousel = new Carousel();

    // Register this module
    window.WayneState.register('carousel', carousel);
})();
