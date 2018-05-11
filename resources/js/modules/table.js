(function() {
    "use strict";

    /**
     * TableStack module.
     */
    class TableStack {

        constructor() {
            this._init();
        }

        /**
         * Initialize
         */
        _init() {
            document.querySelectorAll('table.table-stack').forEach(function (table) {
                table.querySelectorAll('tbody tr').forEach(function (tr) {
                    tr.querySelectorAll('tbody td').forEach(function (td, index) {
                        var heading = table.querySelector('thead th:nth-child(' + (index + 1) + ')');

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
        }
    }

    // Initialize
    var table = new TableStack();

    // Register this module
    window.WayneState.register('table', table);
})();
