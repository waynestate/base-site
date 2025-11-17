<!DOCTYPE html>
<html class="bg-white antialiased" lang="en">
<head>
    @include('components.meta')

    <title>{{ $base['meta']['title'] ?? 'Wayne State University' }}</title>

    <link rel="icon" type="image/x-icon" href="https://wayne.edu/favicon.ico">
    @vite('resources/css/main.css')

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
        @include('components.flag', ['flag' => $base['flag'], 'class' => 'flag--mt'])
    @endif
</header>

<div id="panel" @class(['site-theme', $base['layout_config']['page_class'] ?? ''])>
    @yield('top')

    @if(!empty($base['hero']) && (empty($base['hero']['component']['option']) || $base['hero']['component']['option'] != 'Banner contained'))
        @include('components.hero', ['hero' => $base['hero']])

        @yield('under-hero')
    @endif

    <div class="layout {{ (in_array($base['page']['controller'], config('base.full_width_controllers'))) ? 'layout--full-width' : 'layout--left-menu  max-w-[75em] mx-auto mt:flex' }}">
        @include('partials.nav-left')

        <main class="content-area mx-auto w-full {{ $base['show_site_menu'] === true ? 'max-w-[900px]' : 'max-w-[75rem]' }}{{ (in_array($base['page']['controller'], config('base.full_width_controllers'))) ? ' max-w-full' : '' }}" tabindex="-1">
            @if(!empty($base['hero']) && isset($base['hero']['component']['option']) && $base['hero']['component']['option'] === 'Banner contained')
                @include('components.hero', ['hero' => $base['hero']])
            @endif

            @include('components.breadcrumbs', ['breadcrumbs' => $base['breadcrumbs'] ?? ''])

            <div id="content" tabindex="-1">
                <div class="px-container">
                    @yield('content')
                </div>

                @include('partials.component-loop')
            </div>
        </main>
    </div>

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

@vite('resources/js/main.js')
</body>
</html>
