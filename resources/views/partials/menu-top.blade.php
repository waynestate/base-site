{{--
    $site => array // ['short-title', 'title', 'subsite-folder']
    $top_menu_output => string // '<ul></ul>'
    $surtitle => string // 'Lenore & Vollrad Von Berg'
    $surtitle_url => string // '/natural-histroy'
    $hasSurtitle => boolean // true
--}}

<div class="menu-top__container">
    <div class="menu-top__title" data-short-title="{{ $site['short-title'] }}">
        @if($hasSurtitle)
            <a class="menu-top__surtitle-link" href="{{ $surtitle_url }}">{{ $surtitle }}</a>
        @endif
        <a class="menu-top__title-link" href="/{{ $site['subsite-folder'] !== null ? rtrim($site['subsite-folder'], '/') : '' }}">
            <span @class(['hidden mt:inline' => $site['short-title'] !== ''])>{{ $site['title'] }}</span>
            <span @class(['menu-top__short-title', 'mt:hidden' => !empty($site['short-title']), 'hidden' => $site['short-title'] == ''])>{{ $site['short-title'] }}</span>
        </a>
    </div>

    @if(config('base.top_menu_enabled') === true)
        <div class="menu-top__nav">
            <nav id="top-menu" aria-label="Site menu" tabindex="-1">
                {!! $top_menu_output !!}
            </nav>
        </div>
    @endif

    <button class="menu-top__button menu-toggle menu-icon mt:hidden" data-toggle="menu" aria-controls="menu" aria-label="Menu" tabindex="0">
        <span class="visually-hidden">Menu</span>
    </button>
</div>
