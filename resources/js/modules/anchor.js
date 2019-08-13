(function() {
    "use strict";

    var offset = function offset(el) {
        var rect = el.getBoundingClientRect(),
        scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
        scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        return { top: rect.top + scrollTop, left: rect.left + scrollLeft }
    }

    var scrollToHash = function () {
        var hash = window.location.hash.substring(1);

        if(hash !== '' && document.getElementById(hash)) {
            let y = offset((document.getElementById(hash))).top - document.querySelector('.menu-top-container').offsetHeight;

            window.scroll(0, y);
        }
    }

    // Wait until the page finishes loading so the animate scrollTop doesn't bounce to the top of the pages
    window.onload = function () {
        scrollToHash();
    }

    // Anytime the hash changes after the page is loaded scroll the user to that hash
    if ("onhashchange" in window) {
        window.onhashchange = scrollToHash;
    }
})();
