import 'app';
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
            // Slick Configs
            var config = {
                dots: true,
                arrows: false
            };
            var config_arrows = {
                dots: true,
                arrows: true
            }

            // Replace image sources
            $('img.b-lazy').each(function () {
                $(this).attr('src', $(this).attr('data-src'));
            });

            // Replace background div
            $('div.b-lazy').each(function(){
                $(this).css('background-image', 'url('+$(this).attr('data-src')+')');
            });

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
