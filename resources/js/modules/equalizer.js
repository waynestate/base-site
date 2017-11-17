import jQuery from 'jquery';
import 'foundation-sites/js/foundation.core';
import 'foundation-sites/js/foundation.util.mediaQuery';
import 'foundation-sites/js/foundation.util.timerAndImageLoader';
import 'foundation-sites/js/foundation.equalizer';

(function($) {
    "use strict";

    /**
     * Equalizer module.
     */
    class Equalizer {
        constructor() {
            this._init();
        }

        /**
         * Initialize
         */
        _init() {
            $.each($('[data-equalizer]'), function(key, obj){
                (new window.Foundation.Equalizer($(obj, {
                    'data-equalize-on-stack' : true
                })));
            });
        }
    }

    // Register this module
    window.WayneState.register('equalizer', new Equalizer());
})(jQuery);
