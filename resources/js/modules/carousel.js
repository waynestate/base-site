var Flickity = require('flickity');

(function(Flickity) {
    "use strict";

    if(document.querySelector('.rotate') !== null) {
        new Flickity('.rotate', {
            on: {
                ready: function() {
                    // Get the height of the first image that loaded and dynamically set the height
                    if(document.querySelector('.flickity-enabled .is-selected img') != null) {
                        document.querySelector('.flickity-viewport').style.height = document.querySelector('.flickity-enabled .is-selected img').offsetHeight + 'px';
                    }

                    // Visually hide the dots for accessibility
                    if(document.querySelector('.flickity-page-dots') != null) {
                        document.querySelector('.flickity-page-dots').classList.add('visually-hidden');
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
})(Flickity);
