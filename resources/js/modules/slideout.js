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
        window.scrollTo(0,0);
    });

    // Before opening slideout adjust the icon, classes, and aria values
    slideout.on('beforeopen', function () {
        document.querySelector('#panel').classList.add('min-h-screen');
        document.querySelector('.menu-toggle').classList.add('icon-cancel');
        document.querySelector('.menu-toggle').classList.remove('menu-icon');
        document.querySelector('#menu').classList.remove('hidden');
        document.querySelector('#menu').setAttribute('aria-hidden', 'false');
        window.scrollTo(0,0);
    });

    // Get a list of all menu links
    var all_links = document.querySelectorAll('#menu a');

    // Trap focus within the slideout by tabbing back to the close button
    let tabToCloseButton = function (e) {
        if (!e.shiftKey && e.keyCode == 9) {
            // Wrapping this in a setTimeout prevents it from focusing on the element after this one (unknown bug) 
            setTimeout(function () {
                document.querySelector('button.menu-toggle').focus();
            }, 0);
        }
    }

    // Trap focus within the slideout by tabbing to the last element
    let tabToLastElement = function (e) {
        if (e.shiftKey && e.keyCode == 9) {
            // Wrapping this in a setTimeout prevents it from focusing on the element after this one (unknown bug) 
            setTimeout(function () {
                all_links[all_links.length-1].focus();
            }, 0);
        }
    }

    slideout.on('open', function () {
        // Allow clicking the content area to close offcanvas
        document.querySelector('.content-area').addEventListener('click', function (e) {
            if (slideout.isOpen()) {
                e.preventDefault();
                slideout.close();
            }
        });

        if(all_links.length > 0) {
            // When tabbing off the last link in the menu make it go back to the close button
            all_links[all_links.length-1].addEventListener('keydown', tabToCloseButton);
            
            // When tabbing backwards off the menu toggle goto the last focusable element in the slideout
            document.querySelector('.menu-toggle').addEventListener('keydown', tabToLastElement);
        }

        // Set that it was expanded
        document.querySelector('.menu-toggle').setAttribute('aria-expanded', 'true');
    });

    slideout.on('close', function () {
        // Remove the event listener for closing slideout whenever the slideout closes
        document.querySelector('.content-area').removeEventListener('click', function (e) {
            if (slideout.isOpen()) {
                e.preventDefault();
                slideout.close();
            }
        });

        // Remove listeners for trapping focus within the slideout
        if(all_links.length > 0) {
            all_links[all_links.length-1].removeEventListener('keydown', tabToCloseButton);
        }

        document.querySelector('.menu-toggle').removeEventListener('keydown', tabToLastElement);

        // Set that it was closed
        document.querySelector('.menu-toggle').setAttribute('aria-expanded', 'false');
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

    // Add escape key to close
    document.querySelectorAll('.menu-toggle, #menu a').forEach(function (item) {
        item.addEventListener('keyup', function(e) {
            if(e.keyCode == 27) {
                slideout.close();
            }
        });
    });

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
