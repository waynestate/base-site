import mediabox from 'mediabox';

(function() {
    "use strict";

    /**
     * Media module.
     */
    class Media {

        constructor() {
            this._init();
        }

        /**
         * Initialize
         */
        _init() {
            mediabox('a[href*="youtu.be"], a[href*="youtube.com/watch"]');
        }
    }

    // Initialize
    var media = new Media();

    // Register this module
    window.WayneState.register('media', media);
})();
