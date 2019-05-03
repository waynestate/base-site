import 'accordion/src/accordion.js';

(function() {
    "use strict";

    document.querySelectorAll('.accordion').forEach(function(item) {
        new Accordion(item, {
            onToggle: function(target){
                // Only allow one accordion item open at time
                target.accordion.folds.forEach(fold => {
                    if(fold !== target) {
                        fold.open = false;
                    }
                });

                // Allow the content to be shown if its open or hide it when closed
                target.content.classList.toggle('hidden')
            },
            enabledClass: 'enabled'
        });

        // Hide all accordion content from the start so content inside it isn't part of the tabindex
        item.querySelectorAll('.content').forEach(function(item) {
            item.classList.add('hidden');
        });
    });

    document.querySelectorAll('ul.accordion > li').forEach(function(item) {
        // Apply the required content fold afterwards to simplify the html
        item.querySelector('div').classList.add('fold');

        // Use this span container for the + and - close text and hide it from screen readers
        // item.querySelector('a').insertAdjacentHTML('afterbegin', '<span class="hidden"></span>');
    });
})();
