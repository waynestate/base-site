import jQuery from 'jquery';

(function($) {
    "use strict";

    window.addEventListener('scroll', function() {
        if ($(document).scrollTop() >= $('.wsuheader').outerHeight()) {
            $('.menu-top-placeholder').css('height', $('div.menu-top').outerHeight());
            $('.menu-top-container').addClass('w-full fixed pin-t z-10');
        } else if($(document).scrollTop() < $('.wsuheader').outerHeight()) {
            $('.menu-top-placeholder').css('height', '0px');
            $('.menu-top-container').removeClass('w-full fixed pin-t z-10');
        }
    });
})(jQuery);
