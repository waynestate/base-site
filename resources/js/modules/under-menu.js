(function () {
    "use strict";

    // Only move the under menu buttons if the menu is hidden
    const menu_button = document.querySelector(".menu-toggle");

    if (!menu_button || !menu_button.checkVisibility()) {
        return;
    }

    // Ensure baseline elements exist
    const under_menu_dom = document.querySelector(".under-menu");
    const body_content_dom = document.querySelector("#content .content");

    if (!under_menu_dom || !body_content_dom) {
        return;
    }

    // Ensure there is a place to move the buttons
    const insert_position =
        document.querySelector("#mobile-cta-buttons") ||
        body_content_dom.querySelector("p");

    if (!insert_position) {
        return;
    }

    // Get the buttons to move
    const buttons_under_menu = under_menu_dom.querySelector("ul");
    buttons_under_menu.classList.add("ml-0", "my-3");

    // Insert the buttons into the new location
    if (buttons_under_menu.children.length > 0) {
        insert_position.after(buttons_under_menu);
    }
})();