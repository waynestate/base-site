import jQuery from 'jquery';

(function($) {
    "use strict";

    /**
     * Anchor module.
     */
    class Anchor {
        constructor() {
            this._init();
        }

        /**
         * Initialize
         */
        _init() {
            // Wait until the page finishes loading so the animate scrollTop doesn't bounce to the top of the page
            $(window).on('load', function (){
                this.WayneState.modules.anchor.scrollToHash();
            });

            // Anytime the hash changes after the page is loaded scroll the user to that hash
            if ("onhashchange" in window) {
                window.onhashchange = this.scrollToHash;
            }
        }

        scrollToHash() {
            var hash = window.location.hash.substring(1);

            if(hash !== '' && document.getElementById(hash)) {
                $('html,body').animate({
                    scrollTop: $('#' + hash).offset().top - $('.menu-top-container').outerHeight()
                }, 100);
            }
        }
    }

    // Register this module
    window.WayneState.register('anchor', new Anchor());
})(jQuery);
