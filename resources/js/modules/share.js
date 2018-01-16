import jQuery from 'jquery';

(function($) {
    "use strict";

    /**
     * Sticky module.
     */
    class Share {
        constructor() {
            this._init();
        }

        /**
         * Initialize
         */
        _init() {
            if($('.addthis_sharing_toolbox').length > 0) {
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
                }else{
                    // Refreshes the share icons with the new URLs
                    window.addthis.layers.refresh();
                }
            }
        }
    }

    // Initialize
    var share = new Share();

    // Register this module
    window.WayneState.register('share', share);
})(jQuery);
