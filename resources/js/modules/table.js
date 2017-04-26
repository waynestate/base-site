import 'app';
import jQuery from 'jquery';

(function($) {
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
            $('table.table-stack').each(function () {
                var thetable = $(this);

                $(this).find('tbody td').each(function () {
                    $(this).attr('data-label', thetable.find('thead th:nth-child(' + ($(this).index() + 1) + ')').text());
                });

                $(this).find('tbody th').each(function () {
                    $(this).attr('data-label', thetable.find('thead th:first-child').text());
                });
            });
        }
    }

    // Initialize
    var table = new TableStack();

    // Register this module
    window.WayneState.register('table', table);
})(jQuery);
