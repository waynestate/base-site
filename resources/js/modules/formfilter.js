(function() {
    "use strict";

    document.querySelectorAll('#panel form.filter').forEach(function (item) {
        // Remove the "Filter button
        document.querySelector('input[type="submit"]').style.display = 'none';

        // All drop downs should submit the form
        item.querySelectorAll('select').forEach(function (select) {
            select.addEventListener('change', function () {
                item.closest('form').submit();
            });
        });
    });
})();
