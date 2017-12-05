import jQuery from 'jquery';
import 'foundation-sites/js/foundation.core';
import 'foundation-sites/js/foundation.util.keyboard';
import 'foundation-sites/js/foundation.util.timerAndImageLoader';
import 'foundation-sites/js/foundation.tabs';

(function($) {
    "use strict";

    // Initialize
    $.each($('[data-tabs]'), function(key, obj){
        var tabsName = $(obj).data('tabs');
        var tabs = new window.Foundation.Tabs($(obj));

        // Register this module
        window.WayneState.register('tabs-' + (tabsName !== '' ? tabsName : ''), tabs);
    });
})(jQuery);
