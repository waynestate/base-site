(function() {
    "use strict";

    const tabAreas = document.querySelectorAll('.js-tabArea');
    if (tabAreas.length === 0) return;

    // Activates a tab based on the clicked link
    function activateTab(linkElement) {
        const container = linkElement.closest('.js-tabArea');

        // Deactivate all active items
        container.querySelectorAll('.active').forEach(el => el.classList.remove('active'));

        // Activate the clicked Tab li
        linkElement.parentElement.classList.add('active');

        // Activate the Content Panel using data-target
        const targetSelector = linkElement.dataset.target;
        if (targetSelector) {
            const targetPanel = container.querySelector(targetSelector);
            if (targetPanel) targetPanel.classList.add('active');
        }
    }

    // Click Handler
    function onTabClick(event) {
        event.preventDefault();
        const link = event.target.closest('a');
        if (!link) return;

        activateTab(link);

        // Sets hash to #definition-123
        if (history.pushState) {
            history.pushState(null, null, link.getAttribute('href'));
        } else {
            window.location.hash = link.getAttribute('href');
        }
    }

    // Listen for clicks
    tabAreas.forEach(function(area) {
        const navElement = area.querySelector(' .js-tabNav');
        if (navElement) {
            navElement.addEventListener('click', onTabClick, false);
        }
    });

    // Check if URL Hash matches a tab
    if (window.location.hash) {
        // We look for a link where href="#definition-..." and matches the current hash
        const matchingLink = document.querySelector(`.js-tabNav a[href="${window.location.hash}"]`);

        if (matchingLink) {
            activateTab(matchingLink);
            // Smooth scroll to tabs if deep linked
            matchingLink.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
})();
