import 'accordion/src/accordion.js';

(function() {
    "use strict";

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

    // Apply the required content fold afterwards to simplify the html
    document.querySelectorAll('ul.accordion > li').forEach(function(item) {
        item.querySelector('div').classList.add('fold');
    });
})();
