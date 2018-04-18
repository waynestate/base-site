import jQuery from 'jquery';

(function($) {
    "use strict";

    /**
     * Sticky module.
     */
    class Sticky {
        constructor() {
            this._init();
        }

        /**
         * Initialize
         */
        _init() {
            var hash = window.location.hash.substring(1);

            // Scroll the user to the right spot, offseted by the sticky menu top
            if(hash !== '' && document.getElementById(hash)) {
                $('html,body').animate({
                    scrollTop: $('#' + hash).offset().top - $('.menu-top-container').outerHeight()
                }, 100);
            }
        }
    }

    // Register this module
    window.WayneState.register('sticky', new Sticky());

    window.addEventListener('scroll', function() {
        if ($(document).scrollTop() >= $('.wsuheader').outerHeight()) {
            $('.menu-top-placeholder').css('height', $('.header-menu').outerHeight());
            $('.menu-top-container').addClass('sticky');
        } else if($(document).scrollTop() < $('.wsuheader').outerHeight()) {
            $('.menu-top-placeholder').css('height', '0px');
            $('.menu-top-container').removeClass('sticky');
        }
    });
})(jQuery);
