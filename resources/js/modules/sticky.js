(function() {
    "use strict";

    window.addEventListener('scroll', function() {
        var offsetHeight = 0;

        if(document.querySelector('.wsuheader')) {
            offsetHeight = document.querySelector('.wsuheader').offsetHeight;
        }

        if (window.pageYOffset >= offsetHeight) {
            document.getElementById('panel').style.marginTop = document.querySelector('.menu-top__container').offsetHeight + 'px';
            document.querySelector('.menu-top__container').classList.add('menu-top--sticky');
        } else if(window.pageYOffset < offsetHeight) {
            document.getElementById('panel').style.marginTop = '0px';
            document.querySelector('.menu-top__container').classList.remove('menu-top--sticky');
        }
    });
})();
