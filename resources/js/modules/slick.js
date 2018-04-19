import jQuery from 'jquery';
import 'slick-carousel/slick/slick.js';

(function($) {
    "use strict";

    /**
     * Slick module.
     */
    class Slick {

        constructor() {
            this._init();
        }

        /**
         * Initialize
         */
        _init() {
            var config = {
                dots: true,
                arrows: false
            };
            
            var config_arrows = {
                dots: true,
                arrows: true
            }

            // Initialize Slick
            $('.rotate').slick(config);
            $('.rotate_arrows').slick(config_arrows);
        }
    }

    // Initialize
    var slick = new Slick();

    // Register this module
    window.WayneState.register('slick', slick);
})(jQuery);
