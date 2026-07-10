(function() {
    "use strict";

    const tabAreas = document.querySelectorAll('.js-tabArea');
    if (tabAreas.length === 0) return;

    // 'setFocus' flag to manage visual focus.
    function activateTab(linkElement, setFocus = true) {
        const container = linkElement.closest('.js-tabArea');

        // Reset ARIA and tabindex for all tabs.
        const nav = container.querySelector('.js-tabNav');
        nav.querySelectorAll('a[role="tab"]').forEach(el => {
            el.parentElement.classList.remove('active');
            el.setAttribute('aria-selected', 'false');
            el.setAttribute('tabindex', '-1');
        });

        // Deactivate all active items
        container.querySelectorAll('.tabs__pane-content').forEach(el => el.classList.remove('active'));

        // Activate the clicked Tab li
        linkElement.parentElement.classList.add('active');

        // ARIA, tabindex, and apply focus.
        linkElement.setAttribute('aria-selected', 'true');
        linkElement.setAttribute('tabindex', '0');
        if (setFocus) {
            linkElement.focus();
        }

        // Activate the Content Panel using data-target
        const targetSelector = linkElement.dataset.target;
        if (targetSelector) {
            const targetPanel = container.querySelector(targetSelector);
            if (targetPanel) targetPanel.classList.add('active');
        }
    }

    // Click Handler
    function onTabClick(event) {
        // Target elements with role="tab".
        const link = event.target.closest('a[role="tab"]');
        if (!link) return;

        event.preventDefault();
        activateTab(link);

        // Sets hash to #definition-123
        if (history.pushState) {
            history.pushState(null, null, link.getAttribute('href'));
        } else {
            window.location.hash = link.getAttribute('href');
        }
    }

    // Accessible keyboard navigation (arrows, home, end).
    function onTabKeydown(event) {
        const link = event.target.closest('a[role="tab"]');
        if (!link) return;

        const nav = link.closest('.js-tabNav');
        const tabs = Array.from(nav.querySelectorAll('a[role="tab"]'));
        const index = tabs.indexOf(link);
        let nextIndex = null;

        switch (event.key) {
            case 'ArrowRight':
            case 'ArrowDown':
                nextIndex = (index === tabs.length - 1) ? 0 : index + 1;
                event.preventDefault();
                break;
            case 'ArrowLeft':
            case 'ArrowUp':
                nextIndex = (index === 0) ? tabs.length - 1 : index - 1;
                event.preventDefault();
                break;
            case 'Home':
                nextIndex = 0;
                event.preventDefault();
                break;
            case 'End':
                nextIndex = tabs.length - 1;
                event.preventDefault();
                break;
        }

        if (nextIndex !== null) {
            const nextTab = tabs[nextIndex];
            activateTab(nextTab, true);
        }
    }

    // Listen for clicks
    tabAreas.forEach(function(area) {
        const navElement = area.querySelector('.js-tabNav');
        if (navElement) {
            navElement.addEventListener('click', onTabClick, false);
            navElement.addEventListener('keydown', onTabKeydown, false);
        }
    });

    // Check if URL Hash matches a tab
    if (window.location.hash) {
        const matchingLink = document.querySelector(`.js-tabNav a[href="${window.location.hash}"]`);

        if (matchingLink) {
            // Prevent focus stealing on initial load.
            activateTab(matchingLink, false);
            matchingLink.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
})();
