import 'app';
import jQuery from 'jquery';
import nanobar from 'nanobar/nanobar';
import spf from 'spf/dist/spf';

(function($) {
    "use strict";

    /**
     * SPF module.
     */
    class SpfLoader {

        constructor() {
            this._init();
        }

        /**
         * Unload SPF and remove all listeners
         */
        unload() {
            // Unload SPF
            spf.dispose();

            // Unload App reload
            document.removeEventListener('spfdone', this.reInit);
            document.removeEventListener('spfjsbeforeunload', this.unload);

            // Unload the progress bar
            document.removeEventListener('spfrequest', this.spfrequest);
            document.removeEventListener('spfprocess', this.spfprocess);
            document.removeEventListener('spfdone', this.spfdone);
        }

        /**
         * Initialize SPF
         */
        _init() {
            // Add the spf-link class to trigger all subsequent links to be spf
            $('body').addClass('spf-link');

            // Disable SPF on any links with a file extention
            $("a[href*='.'],a[target=_blank]").each(function(){
                this.classList.add('spf-nolink');
            });

            if (document.addEventListener) {
                document.addEventListener('spfdone', this.reInit);
                document.addEventListener('spfjsbeforeunload', this.unload);
                document.addEventListener('spfrequest', this.spfrequest);
                document.addEventListener('spfprocess',  this.spfprocess);
                document.addEventListener('spfdone', this.spfdone);
            }

            spf.init({
                'cache-unified': true
            });
        }

        /**
         * Wrapper for reInit because if you reference this directly on the listener, it doesn't
         * know about the rest of the class you are in
         */
        reInit() {
            window.WayneState.reInit();

            // Remove spf from form actions
            $('form[action*="spf=navigate"]').each(function(){
                let action = this.getAttribute('action').replace(/\&?spf=navigate/, '');
                this.setAttribute('action', action);
            });
        }

        /**
         * Progress Bar for the request
         */
        spfrequest() {
            window.nanobar.go(80);
        }

        /**
         * Progress Bar for the process
         */
        spfprocess() {
            window.nanobar.go(90);
        }

        /**
         * Progress Bar for done
         */
        spfdone() {
            window.nanobar.go(100);

            // Disable SPF on any links with a file extention
            $("a[href*='.']").each(function(){
                this.classList.add('spf-nolink');
            });
        }
    }

    // Nano bar
    window.nanobar = new nanobar();

    // Initialize Spf, don't register it with our app since we don't want it to be apart of ReInit
    var spfloader = new SpfLoader();
    spfloader._init();
})(jQuery);
