(function() {
    "use strict";

    window.addEventListener('scroll', function() {
        if (window.pageYOffset >= document.querySelector('.wsuheader').offsetHeight) {
            document.querySelector('.menu-top-placeholder').style.height = document.querySelector('div.menu-top').offsetHeight;
            document.querySelector('.menu-top-container').classList.add('w-full', 'fixed', 'pin-t', 'z-10');
        } else if(window.pageYOffset < document.querySelector('.wsuheader').offsetHeight) {
            document.querySelector('.menu-top-placeholder').style.height = '0px';
            document.querySelector('.menu-top-container').classList.remove('w-full', 'fixed', 'pin-t', 'z-10');
        }
    });
})();
