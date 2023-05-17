(function() {
    "use strict";

    // Make sure addthis is desired on this page
    if(document.querySelector('.sharethis-inline-share-buttons') == null) {
        return;
    }

    if (!window.__sharethis__) {
        // Asynchronous load of share icons
        var sharethisScript = document.createElement('script');
        sharethisScript.setAttribute('src', '//platform-api.sharethis.com/js/sharethis.js#property=642aa5765d783b00125f1bfc&product=inline-share-buttons&source=platform');
        sharethisScript.setAttribute('async', 'async');
        document.body.appendChild(sharethisScript);

        return;
    }
})();
