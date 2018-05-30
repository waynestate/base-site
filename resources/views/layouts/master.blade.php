<!DOCTYPE html>
<html class="bg-white antialiased" lang="en">
<head>
    @include('components.meta')

    <title>@include('components.head-title')</title>

    <link rel="icon" type="image/x-icon" href="https://wayne.edu/favicon.ico">
    <link rel="stylesheet" href="{{ mix('_resources/css/main.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet" type="text/css">
    @if(!empty($page['canonical']))<link rel="canonical" href="{{ $page['canonical'] }}">@endif

    @include('components.ga')
</head>
<body class="font-sans font-normal text-black leading-normal text-base">

@include('components.skip')

@include('components.header')

@if(!empty($site))
    @include('components.menu-top', ['site' => $site])
@endif

@if(!empty($banner))
    @include('components.banner', ['banner' => $banner])
@endif

<main id="panel" tabindex="-1">
    @yield('content-area')
</main>

@if(!empty($social))
    @include('components.footer-social', ['social' => $social])
@endif

@if(!empty($contact))
    @include('components.footer-contact', ['contact' => $contact])
@endif

@include('components.footer')

<script src="{{ mix('_resources/js/main.js') }}"></script>
</body>
</html>
