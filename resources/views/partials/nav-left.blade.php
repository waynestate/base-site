<nav id="menu" class="page-menu  {{ $base['show_site_menu'] === false ? ' mt:hidden' : '' }}" aria-label="Page menu" tabindex="-1">
    @if(
        !empty($base['top_menu_output']) &&
        $base['site_menu'] !== $base['top_menu'] &&
        config('base.top_menu_enabled')
    )
        @if(! empty($base['site_menu_output']))
            <div class="slideout-main-menu">
                <ul class="main-menu">
                    <li>
                        <a role="button"
                           class="main-menu-toggle"
                           tabindex="0"
                           aria-expanded="false">
                            {{ config('base.top_menu_label') }}
                        </a>
                        {!! $base['top_menu_output'] !!}
                    </li>
                </ul>
            </div>
        @else
            @if(config('base.top_menu_enabled') === true)
                <div class="mt:hidden">
            @endif
                {!! $base['top_menu_output'] !!}
            @if(config('base.top_menu_enabled') === true)
                </div>
            @endif
        @endif
    @endif

    @if(!empty($base['site_menu_output']))
        {!! $base['site_menu_output'] !!}
    @endif

    @if(!empty($base['flag']))
        @include('components.flag', ['flag' => $base['flag'], 'class' => 'flag--sm'])
    @endif

    @yield('below_menu')

    @if(!empty($base['under_menu']))
        <div class="under-menu">
            @include('components.button-column', ['data' => $base['under_menu']])
        </div>
    @endif
</nav>
