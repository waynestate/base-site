(function() {
    "use strict";

    // Hide the main menu to start
    if(document.querySelector('#menu .menu-top') != null) {
        // Add .hide to .menu-top when it's in .slideout-main-menu
        if(document.querySelector('#menu .slideout-main-menu') != null) {
            document.querySelector('#menu .menu-top').classList.add('hidden');
        } else {
            // Add .main-menu styling class
            document.querySelector('#menu .menu-top').classList.add('main-menu');
        }
    }

    // Add the arrow icons to toggle the main menu
    var parentNode = document.querySelector('a.main-menu-toggle');
    var childNode = document.createElement('span');

    if(parentNode != null) {
        childNode.classList.add('expand-icons');
        childNode.classList.add('icon-right-open');
        childNode.classList.add('float-right');
        childNode.classList.add('text-lg');
        childNode.classList.add('-mt-0.5');
        childNode.setAttribute('aria-hidden', 'true');
        parentNode.prepend(childNode);
    }

    let toggleMainMenu = function () {
        document.querySelector('.slideout-main-menu ul ul').classList.toggle('hidden');

        if(document.querySelector('a.main-menu-toggle').getAttribute('aria-expanded') == 'false') {
            document.querySelector('a.main-menu-toggle').setAttribute('aria-expanded', 'true');
        } else {
            document.querySelector('a.main-menu-toggle').setAttribute('aria-expanded', 'false');
        }

        if(document.querySelector('.slideout-main-menu ul ul').offsetParent === null) {
            document.querySelector('a.main-menu-toggle .expand-icons').classList.toggle('icon-right-open');
            document.querySelector('a.main-menu-toggle .expand-icons').classList.toggle('icon-down-open');
        } else {
            document.querySelector('a.main-menu-toggle .expand-icons').classList.toggle('icon-down-open');
            document.querySelector('a.main-menu-toggle .expand-icons').classList.toggle('icon-right-open');
        }

        // Return false so it does not complete the click through
        return false;
    }

    // Toggle the menu and show the appropriate icons
    if(document.querySelector('a.main-menu-toggle') != null) {
        document.querySelector('a.main-menu-toggle').addEventListener('click', toggleMainMenu);
        document.querySelector('a.main-menu-toggle').addEventListener('keypress', function (e) {
            if(e.keyCode == 13) {
               toggleMainMenu();
            }
        });
    }
})();
