(function() {
    "use strict";

    window.addEventListener('scroll', function() {
        var offsetHeight = 0;

        if(document.querySelector('.wsuheader')) {
            offsetHeight = document.querySelector('.wsuheader').offsetHeight;
        }

        if (window.pageYOffset >= offsetHeight) {
            document.getElementById('panel').style.marginTop = document.querySelector('.nav-top').offsetHeight + 'px';
            document.querySelector('.nav-top').classList.add('nav-top--sticky');
        } else if(window.pageYOffset < offsetHeight) {
            document.getElementById('panel').style.marginTop = '0px';
            document.querySelector('.nav-top').classList.remove('nav-top--sticky');
        }
    });
})();
