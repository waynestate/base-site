import 'accordion/src/accordion.js';

(function() {
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
            document.querySelectorAll('.accordion').forEach(function(item) {
                new Accordion(item, {
                    // Only allow one accordion item open at time
                    onToggle: function(target){
                        target.accordion.folds.forEach(fold => {
                            if(fold !== target) {
                                fold.open = false;
                            }
                        });
                    },
                    enabledClass: 'enabled'
                });
            });

            document.querySelectorAll('ul.accordion > li').forEach(function(item) {
                // Apply the content fold
                item.querySelector('div').classList.add('fold');
            });
        }
    }

    // Initialize
    var accordions = new Accordions();

    // Register this module
    window.WayneState.register('accordions', accordions);
})();
