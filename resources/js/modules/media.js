import Mediabox from "mediabox";

(function(Mediabox) {
    "use strict";

    Mediabox('a[href*="youtu.be"], a[href*="youtube.com/watch"]', { rel: 0 });

    document.querySelectorAll('a[href*="youtu.be"], a[href*="youtube.com/watch"]').forEach(function (item) {
        item.addEventListener('click', function () {
            // Change focus to media box upon opening it
            window.focusedElBeforeOpen = document.activeElement;
            document.querySelector('.mediabox-content').focus();

            // When exiting the media box go back to the previous focus state
            document.querySelector('.mediabox-close').addEventListener('click', function () {
                window.focusedElBeforeOpen.focus();
            });
        });
    });
})(Mediabox);
