<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    @include('partials.meta')

    <title>@include('partials.head-title')</title>

    <link rel="icon" type="image/x-icon" href="https://wayne.edu/favicon.ico">
    <link rel="stylesheet" href="{{ mix('_resources/css/main.css') }}">
    <link href="//fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet" type="text/css">
    @if(!empty($page['canonical']))<link rel="canonical" href="{{ $page['canonical'] }}">@endif

    <script src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/js/vendor/modernizr.js"></script>
    <!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script><![endif]-->
    @include('partials.ga')
</head>
<body class="font-sans font-normal antialiased text-black leading-normal">

<nav aria-label="Skip navigation" class="skip">
    <ul>
        @if(config('app.top_menu_enabled') === true)
            <li><a href="#top-menu">Skip to site menu</a></li>
        @endif
        @if(!empty($site_menu_output))
            <li><a href="#page-menu">Skip to page menu</a></li>
        @endif
        <li><a href="#main">Skip to main content</a></li>
    </ul>
</nav>

@include('partials.header')

<div id="menu-top-section" class="header-menu">
    @if(!empty($site))
        @include('partials.menu-top', ['site' => $site])
    @endif
</div>

<div class="off-canvas-wrapper">
    <div id="content">
        @yield('content-area')
    </div>

    <div id="footer-social">
        @if(!empty($social))
            @include('partials.footer-social', ['social' => $social])
        @endif
    </div>

    <div id="footer-contact">
        @if(!empty($contact))
            @include('partials.footer-contact', ['contact' => $contact])
        @endif
    </div>
</div>

@include('partials.footer')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ mix('_resources/js/main.js') }}"></script>
</body>
</html>
