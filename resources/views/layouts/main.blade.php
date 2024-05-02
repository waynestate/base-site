<!DOCTYPE html>
<html class="bg-white antialiased" lang="en">
<head>
    @include('components.meta')

    <title>{{ $base['meta']['title'] ?? 'Wayne State University' }}</title>

    <link rel="icon" type="image/x-icon" href="https://wayne.edu/favicon.ico">
    <link rel="stylesheet" href="{{ mix('_resources/css/main.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    
    @if(!empty($base['page']['canonical']))<link rel="canonical" href="{{ $base['page']['canonical'] }}">@endif

    @include('components.gtm-head')

    @yield('head')
</head>
<body class="font-sans font-normal text-black leading-normal text-base">

@include('components.gtm-body')
@include('components.skip')

<header>
    @include('components.header')

    @if(!empty($base['site']))
        @include('components.menu-top', ['site' => $base['site'], 'top_menu_output' => $base['top_menu_output']])
    @endif

    @if(!empty($base['flag']))
        @include('components.flag', ['flag' => $base['flag']])
    @endif
</header>

<div id="panel" class="site-theme">
    @yield('top')

    @if(!empty($base['hero']))
        @include('components.hero', ['data' => $base['hero']])

        @yield('under-hero')
    @endif

    @if(!in_array($base['page']['controller'], config('base.full_width_controllers')))<div class="row mt:flex">@endif
        <div class="mt:w-1/4 mt:px-4 mt:block print:hidden {{ $base['show_site_menu'] === false ? ' mt:hidden' : '' }}">
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

                @if(!empty($base['flag']))
                    <div class="min-w-full px-4 mt:px-0 mb-4 mt:hidden">
                        <a href="{{ $base['flag']['link'] }}" class="button w-full flag__title">{{ $base['flag']['title'] }} <span class="flag__excerpt">{{ $base['flag']['excerpt'] }}</span></a>
                    </div>
                @endif

                @yield('below_menu')

                @if(!empty($base['under_menu']))
                    @include('components.button-column', ['data' => $base['under_menu']])
                @endif
            </nav>
        </div>

        <main class="w-full {{$base['show_site_menu'] === true ? 'mt:w-3/4' : '' }} content-area mb-8 print:w-full" tabindex="-1">

            @if(!empty($base['breadcrumbs']))
                @include('components.breadcrumbs', ['breadcrumbs' => $base['breadcrumbs']])
            @endif

            <div id="content" tabindex="-1" class="{{ !in_array($base['page']['controller'], config('base.full_width_controllers')) ? 'px-4' : '' }}">
                @yield('content')
            </div>
        </main>
    @if(!in_array($base['page']['controller'], config('base.full_width_controllers')))</div>@endif

    @yield('bottom')
</div>

<footer>
    @if(!empty($base['social']))
        @include('components.footer-social', ['social' => $base['social']])
    @endif

    @if(!empty($base['contact']))
        @include('components.footer-contact', ['contact' => $base['contact']])
    @endif

    @include('components.footer')
</footer>

<script src="{{ mix('_resources/js/main.js') }}"></script>
</body>
</html>
