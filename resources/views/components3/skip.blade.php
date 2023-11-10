<nav aria-label="Skip navigation" class="skip">
    <ul>
        @if(config('base.top_menu_enabled') === true)
            <li class="skip-site-menu"><a href="#top-menu">Skip to site menu</a></li>
        @endif
        @if(!empty($base['site_menu_output']))
            <li class="skip-page-menu"><a href="#menu">Skip to page menu</a></li>
        @endif
        <li class="skip-menu hidden"><a href="#menu" class="skip-page-menu">Skip to menu</a></li>
        <li><a href="#content">Skip to main content</a></li>
    </ul>
</nav>
