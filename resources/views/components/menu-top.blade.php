{{--
    $site => array // ['title']
    $top_menu_output => string // '<ul></ul>'
--}}
<div class="menu-top-container bg-green-dark">
    <div class="row flex">
        <div class="flex-grow mx-4 py-2" data-short-title="{{ $site['short-title'] !== null ? $site['short-title'] : ''}}">
            @if(config('base.surtitle') !== null && ($site['parent']['id'] === null && config('base.surtitle_main_site_enabled') === true) || ($site['parent']['id'] !== null && config('base.surtitle') !== null))
                <h1 class="text-base mb-0 font-normal">
                    <a href="{{ config('base.surtitle_url') }}" class="text-white">{{ config('base.surtitle') }}</a>
                </h1>

                <h2 class="font-normal text-2xl leading-none"><a href="/{{ $site['subsite-folder'] !== null ? rtrim($site['subsite-folder'], '/') : '' }}" class="text-white">{{ $site['title'] }}</a></h2>
            @else
                <h1 class="font-normal text-2xl leading-none py-3"><a href="/{{ $site['subsite-folder'] !== null ? rtrim($site['subsite-folder'], '/') : '' }}" class="text-white">{{ $site['title'] }}</a></h1>
            @endif
        </div>

        @if(config('base.top_menu_enabled') === true)
            <div class="hidden mx-4 mt:flex mt:flex-no-shrink mt:justify-end mt:items-center">
                <nav id="top-menu" aria-label="Site menu" tabindex="-1">
                    {!! $top_menu_output !!}
                </nav>
            </div>
        @endif

        <div class="flex flex-1 justify-end items-center mx-4 mt:hidden">
            <button class="menu-toggle menu-icon text-white text-3xl mt:hidden" data-toggle="menu" aria-expanded="false" aria-controls="menu" tabindex="0"><span class="visually-hidden">Menu</span></button>
        </div>
    </div>
</div>
