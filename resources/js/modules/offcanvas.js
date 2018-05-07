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
            // Toggle the appropriate classes for offCanvas
            if ($('.menu-button .menu-toggle').is(":visible") === false) {
                $('#menu').removeClass('slideout-menu');
                $('#menu').removeClass('slideout-menu-right');
            } else {
                $('#menu').addClass('slideout-menu');
                $('#menu').addClass('slideout-menu-right');
            }

            window.WayneState.modules.slideout.close();
       }

        /**
         * Initialize
         */
        _init() {
            // Initialize classes
            $('#page-menu').addClass('hidden');

            // Toggle button
            document.querySelector('.menu-toggle').addEventListener('click', function() {
                window.WayneState.modules.slideout.toggle();
            });

            // Scroll the user to the top so they can see the full menu
            window.WayneState.modules.slideout.on('close', function () {
                 // Swap icon
                 $('.menu-toggle').removeClass('icon-cancel-1');
                 $('.menu-toggle').addClass('menu-icon');
                 $('#page-menu').addClass('hidden');
            });

            window.WayneState.modules.slideout.on('beforeopen', function () {
                // Swap icon
                $('.menu-toggle').removeClass('menu-icon');
                $('.menu-toggle').addClass('icon-cancel-1');
                $('#page-menu').removeClass('hidden');

                // Scroll the user to the top so they can see the full menu
                window.scrollTo(0,0);
            });

            // Initialize offcanvas classes
            this.resizeWindow();
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

})(Slideout);
