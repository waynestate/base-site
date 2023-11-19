(function() {
    "use strict";

    document.querySelectorAll('a[href$=".pdf"]').forEach(function(link) {
        const pdfSpan = document.createElement("span");
        const pdfLabel = document.createTextNode(" (pdf)");
        if(link.classList.contains('button') && link.children.length > 0) {
            const lastChild = link.children.length - 1;
            pdfSpan.appendChild(pdfLabel);
            link.children[lastChild].appendChild(pdfSpan);
        } else if(!link.classList.contains('button') && link.getElementsByTagName('img').length > 0) {
            newSpan.appendChild(pdfLabel);
            link.appendChild(pdfSpan);

        } else {
            link.innerHTML += ' (pdf)';
        }
    });
})();
