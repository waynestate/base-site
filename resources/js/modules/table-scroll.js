(function() {
    "use strict";

    document.querySelectorAll('table.overflow-x-scroll').forEach(function(table) {
        // `element` is the element you want to wrap
        const parent = document.querySelector('table.overflow-x-scroll').parentNode;
        var wrapper = document.createElement('div');

        // set the wrapper as child (instead of the element)
        parent.replaceChild(wrapper, table);
        // set element as child of wrapper
        wrapper.appendChild(table);
        wrapper.classList.add('overflow-x-scroll');
        table.classList.remove('overflow-x-scroll');
    });
})();
