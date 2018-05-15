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
