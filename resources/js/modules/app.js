(function() {
    "use strict";

    /**
     * WayneState module.
     */
    class WayneState {

        constructor() {
            // The registered modules
            this.modules = [];
        }

        /**
         * Register a module to reInit later
         */
        register(name, module) {
            // Add the module to the stack
            this.modules[name] = module;
        }

        /**
         * ReInitialize the application
         */
        reInit() {
            // Loop through all the modules and call the _init method
            for(var module in this.modules) {
                // Make sure it has an init method before calling it
                if (typeof this.modules[module]._init !== 'undefined') {
                    // Initialize this module
                    this.modules[module]._init();
                }
            }
        }
    }

    // Attach it so we can use it globally
    window.WayneState = new WayneState();
})();
