<!DOCTYPE html>
<html class="bg-white antialiased" lang="en">
<head>
    @include('components.meta')

    <title>@include('components.head-title')</title>

    <link rel="icon" type="image/x-icon" href="https://wayne.edu/favicon.ico">
    <link rel="stylesheet" href="{{ mix('_resources/css/main.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    
    @if(!empty($base['page']['canonical']))<link rel="canonical" href="{{ $base['page']['canonical'] }}">@endif

    @include('components.gtm-head')
</head>
<body class="font-sans font-normal text-black leading-normal text-base">

@include('components.gtm-body')
@include('components.skip')

<header>
    @include('components.header')

    @if(!empty($base['site']))
        @include('components.menu-top', ['site' => $base['site'], 'top_menu_output' => $base['top_menu_output']])
    @endif

    @if(!empty($base['banner']))
        @include('components.banner', ['banner' => $base['banner']])
    @endif
</header>

<div id="panel">
    @yield('top')

    {{-- define method for replacing hero on homepage --}}
    @if(!empty($base['hero']) && in_array($base['page']['controller'], config('base.hero_full_controllers')))
        @include('components.hero', ['images' => $base['hero']])

        @yield('under-hero')
    @endif

    {{-- can we do this better --}}
    @if(!in_array($base['page']['controller'], config('base.full_width_controllers')))<div class="row mt:flex">@endif

        <div class="mt:w-1/4 mt:px-4 mt:block print:hidden {{ $base['show_site_menu'] === false ? ' mt:hidden' : '' }}">
            @include('components.menu-side')
        </div>

        <main class="content-area w-full mb-8 print:w-full{{ !in_array($base['page']['controller'], config('base.full_width_controllers')) ? ' px-4' : '' }} {{$base['show_site_menu'] === true ? 'mt:w-3/4' : '' }}" tabindex="-1">

            @if(!empty($base['hero']) && !in_array($base['page']['controller'], config('base.hero_full_controllers')))
                @include('components.hero', ['images' => $base['hero']])

                @yield('under-hero')
            @endif

            @if(!empty($base['breadcrumbs']))
                @include('components.breadcrumbs', ['breadcrumbs' => $base['breadcrumbs']])
            @endif

            <div id="content" tabindex="-1">
                @yield('content')
            </div>

            @yield('under-content')

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
