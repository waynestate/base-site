import jQuery from 'jquery';
import 'foundation-sites/js/foundation.core';
import 'foundation-sites/js/foundation.util.mediaQuery';
import 'foundation-sites/js/foundation.util.keyboard';
import 'foundation-sites/js/foundation.util.motion';
import 'foundation-sites/js/foundation.accordion';

(function($) {
    "use strict";

    /**
     * Accordion module.
     */
    class Accordion {
        constructor() {
            this._init();
        }

        /**
         * Initialize
         */
        _init() {
            // Ensure all .accordians have the 'data- attribute
            $('ul.accordion').each(function(){
                $(this).attr('data-accordion', '');
            });

            // Find all accordions on the page
            $('ul.accordion > li').each(function(){
                // Apply container information
                $(this).addClass('accordion-item')
                    .attr('data-accordion-item', '');

                // Apply the title
                $(this).find('a:first').attr('class', 'accordion-title');

                // Apply the content
                $(this).find('div:first').attr('class', 'accordion-content')
                    .attr('data-tab-content', '');
            });

            // Since foundation accordion _init is a private function we'll need to construct the object every page load
            (new window.Foundation.Accordion($('ul.accordion'), {
                allowAllClosed: true
            }));
        }
    }

    // Initialize
    var accordion = new Accordion();

    // Register this module
    window.WayneState.register('accordion', accordion);
})(jQuery);
