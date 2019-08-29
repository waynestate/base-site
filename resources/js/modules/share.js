(function() {
    "use strict";

    // Make sure addthis is desired on this page
    if(document.querySelector('.addthis_sharing_toolbox') == null) {
        return;
    }

    if (!window.addthis) {
        // Load the config first through a script tag since defining it directly here does not work
        var config = document.createElement('script');
        config.innerHTML = "var addthis_config = {ui_508_compliant: true, ui_tabindex: 0, pubid: 'waynestate'}";
        document.body.appendChild(config);

        // Asynchronous load of share icons
        var addthisScript = document.createElement('script');
        addthisScript.setAttribute('src', '//s7.addthis.com/js/300/addthis_widget.js');
        addthisScript.setAttribute('async', 'async');
        document.body.appendChild(addthisScript);

        return;
    }
})();
