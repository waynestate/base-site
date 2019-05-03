<nav aria-label="Skip navigation" class="skip">
    <ul class="list-reset">
        @if(config('base.top_menu_enabled') === true)
            <li><a href="#top-menu" class="skip-site-menu">Skip to site menu</a></li>
        @endif
        @if(!empty($site_menu_output))
            <li><a href="#menu" class="skip-page-menu">Skip to page menu</a></li>
        @endif
        <li><a href="#content">Skip to main content</a></li>
    </ul>
</nav>
