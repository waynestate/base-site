{{--
    $site => array // ['title']
    $top_menu_output => string // '<ul></ul>'
--}}
<div class="menu-top">
    <div class="menu-top-container bg-green-dark">
        <div class="row flex">
            <div class="flex-grow mx-4 py-2">
                @if(config('base.surtitle') !== null)
                    <h1 class="text-base mb-0 font-normal">
                        @if($site['parent']['id'] === null && config('base.surtitle_main_site_enabled') === true || $site['parent']['id'] !== null)
                            <a href="{{ config('base.surtitle_url') }}" class="text-white">{{ config('base.surtitle') }}</a>
                        @endif
                    </h1>
                @endif

                {!! config('base.surtitle') !== null ? '<h2 class="font-normal text-2xl leading-none">' : '<h1 class="font-normal text-2xl leading-none py-3">' !!}
                    <a href="/{{ $site['subsite-folder'] !== null ? rtrim($site['subsite-folder'], '/') : '' }}" class="text-white">{{ $site['title'] }}</a>
                {!! config('base.surtitle') !== null ? '</h2>' : '</h1>' !!}
            </div>

            <div class="hidden mx-4 mt:flex mt:flex-no-shrink mt:justify-end mt:items-center">
                @if(config('base.top_menu_enabled') === true)
                    <nav id="top-menu" aria-label="Site menu" tabindex="-1">
                        {!! $top_menu_output !!}
                    </nav>
                @endif
            </div>

            <div class="flex flex-1 justify-end items-center mx-4 mt:hidden">
                <button class="menu-toggle menu-icon text-white text-3xl mt:hidden" data-toggle="menu" aria-expanded="false" aria-controls="menu" tabindex="0"><span class="visually-hidden">Menu</span></button>
            </div>
        </div>
    </div>

    <div class="menu-top-placeholder"></div>
</div>
