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
         * Opening and closing the offcanvas main main dropdown
         */
        mainMenuToggle() {
            $('a.main-menu-toggle').prepend('<span class="expand-icons icon-right-open-mini float-right text-2xl flex"></span>');

            $('a.main-menu-toggle').click(function() {
                // Show/hide the main menu
                $('.offcanvas-main-menu ul ul').toggle();

                if($('.offcanvas-main-menu ul ul').is(':visible')) {
                    $('a.main-menu-toggle .expand-icons').toggleClass('icon-right-open-mini icon-down-open-mini');
                }else{
                    $('a.main-menu-toggle .expand-icons').toggleClass('icon-down-open-mini icon-right-open-mini');
                }

                // Return false so it does not complete the click through
                return false;
            });
        }

        /**
         * Initialize
         */
        _init() {
            // Initialize classes
            $('#page-menu').addClass('hidden');
            $('#menu .menu-top').addClass('hidden');

            // Toggle button
            document.querySelector('.menu-toggle').addEventListener('click', function() {
                window.WayneState.modules.slideout.toggle();
            });

            // Scroll the user to the top so they can see the full menu
            window.WayneState.modules.slideout.on('close', function () {
                 // Swap icon and adjust screen size
                 $('#panel').removeClass('min-h-screen');
                 $('.menu-toggle').removeClass('icon-cancel-1');
                 $('.menu-toggle').addClass('menu-icon');
                 $('#page-menu').addClass('hidden');
                 $('#page-menu').attr('aria-hidden', 'true');
                 $('.menu-toggle').attr('aria-expanded', 'false');
            });

            window.WayneState.modules.slideout.on('beforeopen', function () {
                // Swap icon and adjust screen size
                $('#panel').addClass('min-h-screen');
                $('.menu-toggle').addClass('icon-cancel-1');
                $('.menu-toggle').removeClass('menu-icon');
                $('#page-menu').removeClass('hidden');
                $('#page-menu').attr('aria-hidden', 'false');
                $('.menu-toggle').attr('aria-expanded', 'true');

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
    document.querySelectorAll('.menu-toggle, #page-menu a').forEach(function (item) {
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
