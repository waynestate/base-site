(function() {
    "use strict";

    document.querySelectorAll('table.table-stack').forEach(function (table) {
        table.querySelectorAll('tbody tr').forEach(function (tr) {
            tr.querySelectorAll('tbody td').forEach(function (td, index) {
                var heading = table.querySelector('thead th:nth-child(' + (index + 1) + ')');

                // Wrap td content in a span for styling
                var tdContent = td.innerHTML;
                td.innerHTML = '<span>' + tdContent + '</span>';

                if(heading != null) {
                    td.setAttribute('data-label', heading.textContent);
                }
            });
        });

        table.querySelectorAll('tbody th').forEach(function (th) {
            var heading = table.querySelector('thead th:first-child');

            if(heading != null) {
                th.setAttribute('data-label', heading.textContent);
            }
        });
    });
})();
