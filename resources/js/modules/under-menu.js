(function () {
    "use strict";
    const menu_button = document.querySelector(".menu-toggle");

    // Only move the under menu buttons if the menu is hidden 
    if (menu_button.offsetHeight !== 0) {
        const under_menu_dom = document.querySelector(".under-menu");
        const body_content = document.querySelector("#content .content");

        // If the elements exist
        if (under_menu_dom && body_content) {

            // Remove the visible bullets
            let under_menu_list = under_menu_dom.querySelector("ul");
            under_menu_list.setAttribute("style", "list-style:none;margin:0;");

            // Inject the elements into the page
            const first_content_p = body_content.getElementsByTagName("p");

            if (first_content_p.length > 0) {
                first_content_p[0].after(under_menu_list);
            } else {
                body_content.appendChild(under_menu_list);
            }
        }
    }
})();