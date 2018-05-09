(function() {
    "use strict";

    /**
     * Form Filter module
     */
    class FormFilter {
        constructor(){
            this._init();
        }

        /*
         * Initialize
         */
        _init(){
            document.querySelectorAll('#content form.filter').forEach(function (item) {
                // Remove the "Filter button
                document.querySelector('input[type="submit"]').style.display = 'none';

                // All drop downs should submit the form
                item.querySelectorAll('select').forEach(function (select) {
                    select.addEventListener('change', function () {
                        item.closest('form').submit();
                    });
                });
            });
        }
    }

    // Initialize
    var formFilter = new FormFilter();

    // Register the module
    window.WayneState.register('formFilter', formFilter);
})();
