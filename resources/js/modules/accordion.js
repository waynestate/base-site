import 'accordion/src/accordion.js';

(function() {
    "use strict";

    document.querySelectorAll('.accordion').forEach(function(item) {
        let accordion = new Accordion(item, {
            onToggle: function(target){
                // Remove IDs from content folds so the browser doesn't jump around when opening an accordion item
                document.querySelectorAll('.accordion li a').forEach(function (item) {
                    item.removeAttribute('id');
                });

                // Only allow one accordion item open at time
                target.accordion.folds.forEach(fold => {
                    if(fold !== target) {
                        fold.open = false;
                        fold.el.firstElementChild.setAttribute('aria-expanded', 'false');
                    }
                });

                // Force the focus on the element they opened
                target.el.firstElementChild.focus();

                // Allow the content to be shown if its open or hide it when closed
                target.content.classList.toggle('hidden')

                // Set accessible state of expanded
                target.el.firstElementChild.setAttribute('aria-expanded', 'true');

                // Update the browsers hash so if the url is copied it will deep link properly
                window.location.hash = target.heading.hash.substr(1);
            },
            enabledClass: 'enabled',
            noAria: true,
            noTransforms: true
        });

        // Hide all accordion content from the start so content inside it isn't part of the tabindex
        item.querySelectorAll('.content').forEach(function(item) {
            item.classList.add('hidden');
        });

        // Apply accessibility attributes
        item.querySelectorAll('li a:first-child').forEach(function(item) {
            item.setAttribute('role', 'button');
            item.setAttribute('aria-expanded', 'false');
        });

        // See if the hash is within this accordion so we can open it
        if(window.location.hash != '') {
            accordion.folds.forEach(function (fold) {
                if(fold.heading.getAttribute('id') == window.location.hash.substr(1)) {
                    window.setTimeout(function () {
                        fold.open = true;
                    }, 500);
                }
            });
        }
    });

    // Apply the required content fold afterwards to simplify the html
    document.querySelectorAll('ul.accordion > li').forEach(function(item) {
        item.querySelector('div').classList.add('fold');
    });
})();
