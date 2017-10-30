import 'app';
import jQuery from 'jquery';
import 'foundation-sites/js/foundation.core';
import 'foundation-sites/js/foundation.util.mediaQuery';
import 'foundation-sites/js/foundation.util.triggers';
import 'foundation-sites/js/foundation.util.motion';
import 'foundation-sites/js/foundation.util.keyboard';
import 'foundation-sites/js/foundation.offcanvas';

(function($) {
    "use strict";

    /**
     * Accordion module.
     */
    class OffCanvas {

        constructor() {
            this._init();
        }

        /**
         *  For resizing the window and figuring out what the state needs to be
         */
        resizeWindow() {
            // Close offcanvas when resizing
            window.WayneState.modules.foundationOffCanvas.close();
            this.close();

            // Toggle the appropriate classes for offCanvas
            if ($('.menu-button .menu-toggle').is(":visible") === false) {
                // Remove classes so the menu is accessible on large screens
                $('#mainMenu').removeClass('position-right');
                $('#mainMenu').removeClass('off-canvas-absolute');
            }else{
                // Disable CSS transitions
                $('#mainMenu').addClass('notransition');

                // Position the menu properly so offcanvas works
                $('#mainMenu').addClass('position-right');
                $('#mainMenu').addClass('off-canvas-absolute');

                // Trigger a reflow, flushing the CSS changes
                $('#mainMenu')[0].offsetHeight;

                // Remove the class so transitions are enabled
                $('#mainMenu').removeClass('notransition');
            }
        }

        /**
         * Opening and closing the offcanvas main main dropdown
         */
        mainMenuToggle() {
            $('.offcanvas-main-menu a.main-menu').prepend('<span class="icon-right-open-mini expand-icons"></span>');

            $('.offcanvas-main-menu a.main-menu').click(function() {
                // Show/hide the main menu
                $('.offcanvas-main-menu ul ul').toggle();

                if($('.offcanvas-main-menu ul ul').is(':visible')) {
                    $('.offcanvas-main-menu a.main-menu .expand-icons').toggleClass('icon-right-open-mini icon-down-open-mini');
                }else{
                    $('.offcanvas-main-menu a.main-menu .expand-icons').toggleClass('icon-down-open-mini icon-right-open-mini');
                }

                // Return false so it does not complete the click through
                return false;
            });
        }

        /**
         * Opening offcanvas
         */
        open() {
            $('.menu-top-container .menu-toggle').removeClass('menu-icon');
            $('.menu-top-container .menu-toggle').addClass('icon-cancel-1');

            return true;
        }

        /**
         * Closing offcanvas
         */
        close() {
            $('.menu-top-container .menu-toggle').removeClass('icon-cancel-1');
            $('.menu-top-container .menu-toggle').addClass('menu-icon');

            return true;
        }

        /**
         * Initialize
         */
        _init() {
            // Make the click link for offcanvas button do nothing, this way #mainMenu doesn't append to the URL
            $('.menu-top-container .menu-toggle').attr('href', 'javascript:void(0);');

            // Initialize offcanvas classes
            this.resizeWindow();

            // Toggle the Main Menu within offcanvas
            this.mainMenuToggle();

            // If offcanvas is closing
            $('.off-canvas-wrapper').on('closed.zf.offcanvas', this.close);

            // If ooffcanvas is opening
            $('.off-canvas-wrapper').on('opened.zf.offcanvas', this.open);

            // Apply initial classes
            $('ul.menu-top').addClass('show-for-menu-top-up');

            // Redo offCanvas because of the random hash it creates so in SPF it will work
            var foundationOffCanvas = new window.Foundation.OffCanvas($('[data-off-canvas]'));
            window.WayneState.register('foundationOffCanvas', foundationOffCanvas);
        }
    }


    if($('[data-off-canvas]').length !== 0) {
        // Initialize and register Foundation's offCanvas
        var foundationOffCanvas = new window.Foundation.OffCanvas($('[data-off-canvas]'));
        window.WayneState.register('foundationOffCanvas', foundationOffCanvas);

        // Initialize and register offCanvas
        var offcanvas = new OffCanvas();
        window.WayneState.register('offcanvas', offcanvas);

        // When resizing the browse reset the state of offcanvas
        window.addEventListener('resize', function () {
            window.WayneState.modules.offcanvas.resizeWindow();
        });
    }
})(jQuery);
