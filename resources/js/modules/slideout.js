import Slideout from 'slideout/dist/slideout.js';

(function(Slideout) {
    "use strict";

    // Initialize slideout
    var slideout = new Slideout({
        'panel': document.getElementById('panel'),
        'menu': document.getElementById('menu'),
        'padding': -1,
        'tolerance': 70,
        'side': 'right',
    });

    // When closing slideout adjust the icon, classes and aria values
    slideout.on('close', function () {
        // Swap icon and adjust screen size
        document.querySelector('#panel').classList.remove('min-h-screen');
        document.querySelector('.menu-toggle').classList.remove('icon-cancel');
        document.querySelector('.menu-toggle').classList.add('menu-icon');
        document.querySelector('#menu').classList.add('hidden');
        document.querySelector('#menu').setAttribute('aria-hidden', 'true');
        document.querySelector('.menu-toggle').setAttribute('aria-expanded', 'false');
        window.scrollTo(0,0);
    });

    // Before opening slideout adjust the icon, classes, and aria values
    slideout.on('beforeopen', function () {
        document.querySelector('#panel').classList.add('min-h-screen');
        document.querySelector('.menu-toggle').classList.add('icon-cancel');
        document.querySelector('.menu-toggle').classList.remove('menu-icon');
        document.querySelector('#menu').classList.remove('hidden');
        document.querySelector('#menu').setAttribute('aria-hidden', 'false');
        document.querySelector('.menu-toggle').setAttribute('aria-expanded', 'true');
        window.scrollTo(0,0);
    });

    // Allow clicking the content area to close offcanvas
    slideout.on('open', function () {
        document.querySelector('.content-area').addEventListener('click', function (e) {
            if (slideout.isOpen()) {
                e.preventDefault();
                slideout.close();
            }
        });
    });

    // Remove the event listener for closing slideout whenever the slideout closes
    slideout.on('close', function () {
        document.querySelector('.content-area').removeEventListener('click', function (e) {
            if (slideout.isOpen()) {
                e.preventDefault();
                slideout.close();
            }
        });
    });

    // Toggle the appropriate classes for slideout based on the menu icon's visibility state
    var toggleSlideout = function () {
        if(document.querySelector('.menu-toggle').offsetParent === null) {
            document.querySelector('#menu').classList.remove('slideout-menu');
            document.querySelector('#menu').classList.remove('slideout-menu-right');
        } else {
            document.querySelector('#menu').classList.add('slideout-menu');
            document.querySelector('#menu').classList.add('slideout-menu-right');
        }

        slideout.close();
    }

    // When resizing the browse reset the state of offcanvas
    window.addEventListener('resize', function () {
        toggleSlideout();
    });

    // Toggle button
    document.querySelector('.menu-toggle').addEventListener('click', function() {
        slideout.toggle();
    });

     // When tabbing open offcanvas
     document.querySelector('.menu-toggle').addEventListener('keyup', function (e) {
        if (e.keyCode == 9) {
            slideout.open();
        }
    });

    // Add escape key to close
    document.querySelectorAll('.menu-toggle, #menu a').forEach(function (item) {
        item.addEventListener('keyup', function(e) {
            if(e.keyCode == 27) {
                slideout.close();
            }
        });
    });

    // Get a list of all menu links
    var all_links = document.querySelectorAll('#menu a');

    // When tabbing off the last link in the menu close offcanvas
    if(all_links.length > 0) {
        all_links[all_links.length -1].addEventListener('keydown', function (e) {
            if (e.keyCode == 9) {
                slideout.close();
            }
        });
    }

    // Hide slideout menu now that javascript is available
    if(document.querySelector('#menu') != null) {
        document.querySelector('#menu').classList.add('hidden');
        document.querySelector('#menu').classList.add('mt:block');
    }

    // Add flexbox classes now that javascript is available
    if(document.querySelector('#panel .mt\\:flex') != null) {
        document.querySelector('#panel .mt\\:flex').classList.add('flex');
        document.querySelector('#panel .mt\\:flex').classList.remove('mt:flex');
    }

    // Check if we need to toggle the slideout on intial load
    toggleSlideout();
})(Slideout);
