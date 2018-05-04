import jQuery from 'jquery';
import 'accordion/src/accordion.js';

(function($) {
    "use strict";

    /**
     * Accordions module.
     */
    class Accordions {
        constructor() {
            this._init();
        }

        /**
         * Initialize
         */
        _init() {
            $('.accordion').each(function() {
                new Accordion(this, {
                    // Only allow one accordion item open at time
                    onToggle: function(target){
                        target.accordion.folds.forEach(fold => {
                            if(fold !== target) {
                                fold.open = false;
                            }
                        });
                    }
                });
            });

            $('ul.accordion > li').each(function(){
                // Make the items absolute positioning now that we know javascript is enabled
                $(this).addClass('absolute');

                // Apply the content fold
                $(this).find('div:first').attr('class', 'fold');
            });
        }
    }

    // Initialize
    var accordions = new Accordions();

    // Register this module
    window.WayneState.register('accordions', accordions);
})(jQuery);
