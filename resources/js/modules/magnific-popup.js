import jQuery from 'jquery';
import 'magnific-popup/dist/jquery.magnific-popup.js';

(function($) {
    "use strict";

    /**
     * Magnific Popup module.
     */
    class MagnificPopup {

        constructor() {
            this._init();
        }

        /**
         * Initialize
         */
        _init() {
            $('a[href*="youtu.be"], a[href*="youtube.com/watch"]').magnificPopup({
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false,
                iframe: {
                    patterns: {
                        shortyoutube: {
                            // String that detects type of video (in this case youtu.be short url).
                            index: 'youtu.be/',
                            id: function(url){
                                // Parse and get the Video ID from the youtu.be short URL
                                var re = /youtu\.be\/([^"&?\/]{11})/i;
                                var id = url.match(re);

                                // Return the ID for the YouTube video
                                return id[1];
                            },
                            // URL that will be set as a source for iframe.
                            src: '//www.youtube.com/embed/%id%?autoplay=1'
                        },
                    }
                }
            });
        }
    }

    // Initialize
    var magnificpopup = new MagnificPopup();

    // Register this module
    window.WayneState.register('magnificpopup', magnificpopup);
})(jQuery);
