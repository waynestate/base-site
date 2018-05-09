(function() {
    "use strict";

    /**
     * Share module.
     */
    class Share {
        constructor() {
            this._init();
        }

        /**
         * Initialize
         */
        _init() {
            // Make sure addthis is desired on this page
            if(document.querySelector('.addthis_sharing_toolbox') == null) {
                return;
            }

            if (!window.addthis) {
                // Asynchronous load of share icons
                var addthisScript = document.createElement('script');
                addthisScript.setAttribute('src', '//s7.addthis.com/js/300/addthis_widget.js#pubid=waynestate');
                addthisScript.setAttribute('async', 'async');
                document.body.appendChild(addthisScript);

                // Custom configuration for share icons
                var addthis_config = addthis_config || {};
                addthis_config.ui_508_compliant = true;
                addthis_config.ui_tabindex = 0;

                return;
            }

            // Refreshes the share icons with the new URLs
            window.addthis.layers.refresh();
        }
    }

    // Initialize
    var share = new Share();

    // Register this module
    window.WayneState.register('share', share);
})();
