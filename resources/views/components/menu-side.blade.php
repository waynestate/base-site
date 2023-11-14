<nav id="menu" aria-label="Page menu" tabindex="-1">
    @if(!empty($base['top_menu_output']) && $base['site_menu'] !== $base['top_menu'] && config('base.top_menu_enabled'))
        @if(!empty($base['top_menu_output']))
            <div class="slideout-main-menu mt:hidden">
                <ul class="main-menu mb-2">
                    <li>
                        <a role="button" class="main-menu-toggle pt-2 pb-2 pl-3 pr-3 block" tabindex="0" aria-expanded="false">{{ config('base.top_menu_label') }}</a>
                        {!! $base['top_menu_output'] !!}
                    </li>
                </ul>
            </div>
        @else
            {!! $base['top_menu_output'] !!}
        @endif
    @endif

    @if(!empty($base['site_menu_output']))
        {!! $base['site_menu_output'] !!}
    @endif

    @if(!empty($base['banner']))
        <div class="min-w-full px-4 mt:px-0 mb-4 mt:hidden">
            <a href="{{ $base['banner']['link'] }}" class="button w-full banner__title">{{ $base['banner']['title'] }} <span class="banner__excerpt">{{ $base['banner']['excerpt'] }}</span></a>
        </div>
    @endif

    @yield('below_menu')

    @if(!empty($base['under_menu']))
        @include('components.under-menu', ['buttons' => $base['under_menu'], 'class' => 'under-menu'])
    @endif
</nav>
