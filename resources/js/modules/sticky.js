import jQuery from 'jquery';

(function($) {
    "use strict";

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
