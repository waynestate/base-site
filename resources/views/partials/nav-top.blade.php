{{--
    $site => array // ['short-title', 'title', 'subsite-folder']
    $top_menu_output => string // '<ul></ul>'
    $surtitle => string // 'Lenore & Vollrad Von Berg'
    $surtitle_url => string // '/natural-histroy'
    $hasSurtitle => boolean // true
--}}

<div class="nav-top">
    <div class="nav-top__title" data-short-title="{{ $site['short-title'] }}">
        @if($hasSurtitle)
            <a class="nav-top__surtitle-link" href="{{ $surtitle_url }}">{{ $surtitle }}</a>
        @endif
        <a class="nav-top__title-link" href="/{{ $site['subsite-folder'] !== null ? rtrim($site['subsite-folder'], '/') : '' }}">
            <span @class(['hidden mt:inline' => $site['short-title'] !== ''])>{{ $site['title'] }}</span>
            <span @class(['nav-top__short-title', 'mt:hidden' => !empty($site['short-title']), 'hidden' => $site['short-title'] == ''])>{{ $site['short-title'] }}</span>
        </a>
    </div>

    @if(config('base.top_menu_enabled') === true)
        <div class="nav-top__nav">
            <nav id="site-menu" aria-label="Site menu" tabindex="-1">
                {!! $top_menu_output !!}
            </nav>
        </div>
    @endif

    <button class="nav-top__button menu-toggle menu-icon mt:hidden" data-toggle="menu" aria-controls="menu" aria-label="Menu" tabindex="0">
        <span class="visually-hidden">Menu</span>
    </button>
</div>
