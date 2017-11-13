import jQuery from 'jquery';

(function($) {
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
            $('#content form.filter').each(function () {
                // Remove the "Filter button
                $(this).find('input[type="submit"]').hide();

                // All drop downs should submit the form
                $(this).find('select').change(function () {
                    $(this).closest('form').trigger('submit');
                });
            });
        }
    }

    // Initialize
    var formFilter = new FormFilter();

    // Register the module
    window.WayneState.register('formFilter', formFilter);
})(jQuery);
