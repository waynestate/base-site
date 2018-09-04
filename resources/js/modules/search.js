(function() {
    "use strict";

    const short_title = document.querySelector("h1.short-title");
    const search_field = document.getElementById("q");

    if (short_title && search_field) {
        search_field.setAttribute(
            "placeholder",
            "Search " + short_title.textContent.trim() + "..."
        );
    }
})();
