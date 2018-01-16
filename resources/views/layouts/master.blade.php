<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Author" content="Wayne State University" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <title>@include('partials.head-title')</title>

    <link rel="icon" type="image/x-icon" href="https://wayne.edu/favicon.ico" />
    <link rel="stylesheet" href="{{ mix('_resources/css/main.css') }}" />
    <link href="//fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet" type="text/css">

    <script src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/js/vendor/modernizr.js"></script>
    <!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script><![endif]-->
    @include('partials.ga')

    <meta class="foundation-mq">
</head>
<body>

@include('partials.header')

<div id="menu-top-section" class="header-menu">
    @include('partials.menu-top', ['site' => $site])
</div>

<div class="off-canvas-wrapper">
    <div id="content">
        @yield('content-area')
    </div>

    <div id="footer-social">
        @if(isset($social) && count($social) > 0)
            @include('partials.footer-social', ['social' => $social])
        @endif
    </div>

    <div id="footer-contact">
        @if(isset($contact) && count($contact) > 0)
            @include('partials.footer-contact', ['contact' => $contact])
        @endif
    </div>
</div>

@include('partials.footer')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ mix('_resources/js/main.js') }}"></script>
</body>
</html>
