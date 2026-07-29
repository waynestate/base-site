(function() {
    "use strict";

    document.querySelectorAll('a[href$=".pdf"]').forEach(function(link) {
        if (hasPdfLabel(link)) {
            return;
        }

        const lastTextNode = getLastTextNode(link);

        if (lastTextNode) {
            lastTextNode.textContent = lastTextNode.textContent.replace(/\s*$/, ' (pdf)');
            return;
        }

        if (hasImageOrSvg(link)) {
            appendPdfSpan(link);
        }
    });

    function hasPdfLabel(link) {
        return hasPdfText(link.textContent)
            || hasPdfText(link.getAttribute('aria-label') || '');
    }

    function hasPdfText(text) {
        return /(?:\(\s*pdf\s*\)|\bpdf\b)/i.test(text);
    }

    function hasImageOrSvg(link) {
        return Boolean(link.querySelector('img, svg'));
    }

    function appendPdfSpan(link) {
        link.classList.add('pdf-image');

        const pdfSpan = document.createElement('span');
        pdfSpan.appendChild(document.createTextNode(' (pdf)'));

        link.appendChild(pdfSpan);
    }

    function getLastTextNode(element) {
        const walker = document.createTreeWalker(
            element,
            NodeFilter.SHOW_TEXT,
            {
                acceptNode: function(node) {
                    return node.textContent.trim().length > 0
                        ? NodeFilter.FILTER_ACCEPT
                        : NodeFilter.FILTER_REJECT;
                }
            }
        );

        let currentNode;
        let lastTextNode = null;

        while ((currentNode = walker.nextNode())) {
            lastTextNode = currentNode;
        }

        return lastTextNode;
    }
})();