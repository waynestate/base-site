<nav id="menu" class="px-container-lg mt:w-80 {{ $base['show_site_menu'] === false ? ' mt:hidden' : '' }}" aria-label="Page menu" tabindex="-1">
    @if(!empty($base['top_menu_output']) && $base['site_menu'] !== $base['top_menu'] && config('base.top_menu_enabled'))
        @if(! empty($base['site_menu_output']))
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
