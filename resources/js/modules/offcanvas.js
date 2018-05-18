import Slideout from 'slideout/dist/slideout.js';

(function(Slideout) {
    "use strict";

    /**
     * OffCanvas module.
     */
    class OffCanvas {

        constructor() {
            this._init();
        }

        /*
        *  For resizing the window and figuring out what the state needs to be
        */
       resizeWindow() {
            // Toggle the appropriate classes for offCanvas based on the menu icon's visibility state
            if(document.querySelector('.menu-button .menu-toggle').offsetParent === null) {
                document.querySelector('#menu').classList.remove('slideout-menu');
                document.querySelector('#menu').classList.remove('slideout-menu-right');
            } else {
                document.querySelector('#menu').classList.add('slideout-menu');
                document.querySelector('#menu').classList.add('slideout-menu-right');
            }

            window.WayneState.modules.slideout.close();
       }

        /**
         * Opening and closing the offcanvas main main dropdown
         */
        mainMenuToggle() {
            // Add the arrow icons to toggle the main menu
            var parentNode = document.querySelector('a.main-menu-toggle');
            var childNode = document.createElement('span');
            
            if(parentNode != null) {
                childNode.classList.add('expand-icons', 'icon-right-open', 'float-right', 'text-lg', '-mt-0.5');
                parentNode.prepend(childNode);
            }

            // Toggle the menu and show the appropriate icons
            if(document.querySelector('a.main-menu-toggle') != null) {
                document.querySelector('a.main-menu-toggle').addEventListener('click', function (){
                    document.querySelector('.offcanvas-main-menu ul ul').classList.toggle('hidden');

                    if(document.querySelector('.offcanvas-main-menu ul ul').offsetParent === null) {
                        document.querySelector('a.main-menu-toggle .expand-icons').classList.toggle('icon-right-open');
                        document.querySelector('a.main-menu-toggle .expand-icons').classList.toggle('icon-down-open');
                    } else {
                        document.querySelector('a.main-menu-toggle .expand-icons').classList.toggle('icon-down-open');
                        document.querySelector('a.main-menu-toggle .expand-icons').classList.toggle('icon-right-open');
                    }

                    // Return false so it does not complete the click through
                    return false;
                });
            }
        }

        /**
         * Initialize
         */
        _init() {
            // Initialize classes
            if(document.querySelector('#menu') != null) {
                document.querySelector('#menu').classList.add('hidden', 'mt:block');
            }
            if(document.querySelector('#menu .menu-top') != null) {
                document.querySelector('#menu .menu-top').classList.add('hidden');
            }

            // Toggle button
            document.querySelector('.menu-toggle').addEventListener('click', function() {
                window.WayneState.modules.slideout.toggle();
            });

            // Scroll the user to the top so they can see the full menu
            window.WayneState.modules.slideout.on('close', function () {
                 // Swap icon and adjust screen size
                 document.querySelector('#panel').classList.remove('min-h-screen');
                 document.querySelector('.menu-toggle').classList.remove('icon-cancel');
                 document.querySelector('.menu-toggle').classList.add('menu-icon');
                 document.querySelector('#menu').classList.add('hidden');
                 document.querySelector('#menu').setAttribute('aria-hidden', 'true');
                 document.querySelector('.menu-toggle').setAttribute('aria-expanded', 'false');
            });

            window.WayneState.modules.slideout.on('beforeopen', function () {
                // Swap icon and adjust screen size
                document.querySelector('#panel').classList.add('min-h-screen');
                document.querySelector('.menu-toggle').classList.add('icon-cancel');
                document.querySelector('.menu-toggle').classList.remove('menu-icon');
                document.querySelector('#menu').classList.remove('hidden');
                document.querySelector('#menu').setAttribute('aria-hidden', 'false');
                document.querySelector('.menu-toggle').setAttribute('aria-expanded', 'true');

                // Scroll the user to the top so they can see the full menu
                window.scrollTo(0,0);
            });

            // Initialize offcanvas classes
            this.resizeWindow();

            // Toggle the Main Menu within offcanvas
            this.mainMenuToggle();
        }
    }

    // Initialize and register Slideout
    var slideout = new Slideout({
        'panel': document.getElementById('panel'),
        'menu': document.getElementById('menu'),
        'padding': -1, // ideally this should be 0 but you can't set that
        'tolerance': 70,
        'side': 'right',
    });
    window.WayneState.register('slideout', slideout);

    // Initialize and register offCanvas
    var offcanvas = new OffCanvas();
    window.WayneState.register('offcanvas', offcanvas);

    // When resizing the browse reset the state of offcanvas
    window.addEventListener('resize', function () {
        window.WayneState.modules.offcanvas.resizeWindow();
    });

    // When tabbing open offcanvas
    document.querySelector('.menu-toggle').addEventListener('keyup', function (e) {
        if (e.keyCode == 9) {
            window.WayneState.modules.slideout.open();
        }
    });

    // Add escape key to close
    document.querySelectorAll('.menu-toggle, #menu a').forEach(function (item) {
        item.addEventListener('keyup', function(e) {
            if(e.keyCode == 27) {
                window.WayneState.modules.slideout.close();
            }
        });
    });

    // Get a list of all menu links
    var all_links = document.querySelectorAll('#menu a');

    // When tabbing off the last link in the menu close offcanvas
    all_links[all_links.length -1].addEventListener('keydown', function (e) {
        if (e.keyCode == 9) {
            window.WayneState.modules.slideout.close();
        }
    });

})(Slideout);
