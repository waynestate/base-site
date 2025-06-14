{{--
    $site => array // ['short-title', 'title', 'subsite-folder']
    $top_menu_output => string // '<ul></ul>'
--}}

@php
    $hasSurtitle = (
        (config('base.surtitle') !== null &&
        ($site['parent']['id'] === null && config('base.surtitle_main_site_enabled') === true) ||
        ($site['parent']['id'] !== null && config('base.surtitle') !== null)) &&
        !config('base.global.sites.' . $site['id'] . '.surtitle_disabled')
    );
@endphp

<div class="menu-top-container bg-green-600 print:bg-transparent">
    <div class="row flex justify-between">
        <div class="grow-0 mx-4 {{ $hasSurtitle ? 'py-[5px]' : 'py-2' }}" data-short-title="{{ $site['short-title'] }}">
            @if($hasSurtitle)
                <div class="text-base mb-0 font-normal leading-tight">
                    <a href="{{ config('base.surtitle_url') }}" class="text-white print:text-black inline-block py-[3px]">{{ config('base.surtitle') }}</a>
                </div>

                <div class="font-normal mb-1 text-2xl leading-none">
                    <a href="/{{ $site['subsite-folder'] !== null ? rtrim($site['subsite-folder'], '/') : '' }}" class="text-white print:text-black">
                        @if($site['short-title'] !== '')
                            <span class="mt:hidden">{{ $site['short-title'] }}</span>
                            <span class="hidden mt:inline">{{ $site['title'] }}</span>
                        @else
                            {{ $site['title'] }}
                        @endif
                    </a>
                </div>
            @else
                <div class="font-normal mb-0 text-2xl leading-none py-3">
                    <a href="/{{ $site['subsite-folder'] !== null ? rtrim($site['subsite-folder'], '/') : '' }}" class="text-white print:text-black">
                        @if($site['short-title'] !== '')
                            <span class="mt:hidden">{{ $site['short-title'] }}</span>
                            <span class="top_menu_hidden mt:inline">{{ $site['title'] }}</span>
                        @else
                            {{ $site['title'] }}
                        @endif
                    </a>
                </div>
            @endif
        </div>

        @if(config('base.top_menu_enabled') === true)
            <div class="top_menu_hidden mx-4 mt:flex mt:shrink-0 mt:justify-end mt:items-center">
                <nav id="top-menu" aria-label="Site menu" tabindex="-1">
                    {!! $top_menu_output !!}
                </nav>
            </div>
        @endif

        <div class="flex flex-1 justify-end items-center mx-4 mt:hidden">
            <button class="menu-toggle menu-icon text-white print:text-black text-3xl mt:hidden" data-toggle="menu" aria-controls="menu" aria-label="Menu" tabindex="0"><span class="visually-hidden">Menu</span></button>
        </div>
    </div>
</div>
