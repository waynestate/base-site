(function() {
    "use strict";

    const short_title = document.querySelector("[data-short-title]");
    const search_label = document.querySelector("label[for='q']");
    const search_field = document.getElementById("q");

    if (short_title && search_field && search_label) {
        const search_text = "Search " + short_title.dataset.shortTitle.trim();

        search_label.textContent = search_text.trim();
        search_field.setAttribute("placeholder", search_text.trim() + "...");
    }
})();
