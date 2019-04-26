(function() {
    "use strict";

    document.querySelectorAll('a[href$=".pdf"]').forEach(function(item) {
        item.innerHTML += ' (pdf)';
    });
})();
