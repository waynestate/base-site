(function() {
    "use strict";

    if(document.querySelectorAll('a[data-flickr-embed="true"]').length > 0) {
        var flickrembedScript = document.createElement('script');
        flickrembedScript.setAttribute('src', '//embedr.flickr.com/assets/client-code.js');
        flickrembedScript.setAttribute('async', 'async');
        document.body.appendChild(flickrembedScript);
    }
})();
