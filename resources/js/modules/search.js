(function() {
    "use strict";

    const short_title = document.querySelector("[data-short-title]");
    const search_field = document.getElementById("q");

    if (short_title && search_field && short_title.dataset.shortTitle !== "") {
        search_field.setAttribute(
            "placeholder",
            "Search " + short_title.dataset.shortTitle.trim() + "..."
        );
    }
})();
