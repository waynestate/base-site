import 'accordion/src/accordion.js';

(function() {
    "use strict";

    document.querySelectorAll('a[href$=".pdf"]').forEach(function(item) {
        item.innerHTML += ' (pdf)';
    });
})();
