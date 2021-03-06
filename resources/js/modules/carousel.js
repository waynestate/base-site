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

        document.querySelector('.rotate').removeAttribute('tabindex');

        let EnableTabbableItems = function () {
            // Don't allow tabbing to items that aren't selected
            document.querySelectorAll('.rotate .content a').forEach(function (item) {
                item.classList.add('hidden');
            });

            // Allow tabbing to the selected item
            document.querySelectorAll('.rotate .is-selected .content a').forEach(function (item) {
                item.classList.remove('hidden');
            });
        }

        EnableTabbableItems();

        document.querySelectorAll('.flickity-button').forEach(function (item) {
           item.addEventListener('click', EnableTabbableItems);
        });
    }
})(Flickity);
