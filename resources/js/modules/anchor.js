(function() {
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
            // Wait until the page finishes loading so the animate scrollTop doesn't bounce to the top of the pages
            window.onload = function () {
                this.WayneState.modules.anchor.scrollToHash();
            }


            // Anytime the hash changes after the page is loaded scroll the user to that hash
            if ("onhashchange" in window) {
                window.onhashchange = this.scrollToHash;
            }
        }

        scrollToHash() {
            var hash = window.location.hash.substring(1);

            if(hash !== '' && document.getElementById(hash)) {
                let y = document.getElementById(hash).offsetTop - document.querySelector('.menu-top-container').offsetHeight;

                window.scroll(0, y);
            }
        }
    }


    // Register this module
    window.WayneState.register('anchor', new Anchor());
})();
