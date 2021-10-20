<!DOCTYPE html>
<html class="bg-white antialiased" lang="en">
<head>
    @include('components.meta')

    <title>@include('components.head-title')</title>

    <link rel="icon" type="image/x-icon" href="https://wayne.edu/favicon.ico">
    <link rel="stylesheet" href="{{ mix('_resources/css/main.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet" type="text/css">
    @if(!empty($base['page']['canonical']))<link rel="canonical" href="{{ $base['page']['canonical'] }}">@endif

    @include('components.ga')
</head>
<body class="font-sans font-normal text-black leading-normal text-base">

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
    @yield('content-area')
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
