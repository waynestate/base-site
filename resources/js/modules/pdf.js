(function() {
    "use strict";

    document.querySelectorAll('a[href$=".pdf"]').forEach(function(link) {
        if (hasPdfLabel(link)) {
            return;
        }

        const lastTextNode = getLastTextNode(link);

        if (lastTextNode) {
            lastTextNode.textContent = lastTextNode.textContent.replace(/\s*$/, ' (pdf)');
        } else {
            link.appendChild(document.createTextNode(' (pdf)'));
        }
    });

    function hasPdfLabel(link) {
        return /(?:\(\s*pdf\s*\)|\bpdf\b)/i.test(link.textContent);
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